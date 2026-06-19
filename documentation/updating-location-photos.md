# Updating Location Photos

Each region's prayer card can show a "One Shot Prayer Walk" photo. This guide explains
where those photos live and how to add, replace, or remove one.

## Where the photos live

Location photos are **not** stored in this WordPress repo. They live in a public Google
Cloud Storage bucket, `location-grid-images`, in the **Disciple Tools Maps** Google Cloud
organization. The site reads from it over HTTPS:

```
https://storage.googleapis.com/location-grid-images/v1/
```

Two things matter inside the bucket:

| What | Path |
|------|------|
| The image files for one region | `v1/grid/{grid_id}/photos/{filename}` |
| The manifest listing which photos exist | `v1/grid.json` |

The manifest is the source of truth. Uploading an image alone does nothing — a region only
shows photos that are listed for its grid id in `grid.json`.

`grid.json` looks like this (one entry per region, plus a top-level `version`):

```json
{
  "version": 1656105125,
  "100131323": { "maps": [], "photos": ["kankan.jpeg"] },
  "100131324": { "maps": [], "photos": ["..."] }
}
```

## How the site picks a photo

When a prayer card is built, the code reads the manifest for that region and picks **one
photo at random** from its `photos` array
(`pages/pray/stacker-positions.php` → `PG_Stacker_Positions::_position_1()`, via
`pg_images()` in `utilities/global-utilities.php`).

Consequence: if you want a region to always show a specific photo, that photo must be the
**only** entry in the array. Adding a second photo keeps the old one in rotation.

## Finding a region's grid id

The grid id is the numeric key used everywhere above. Find it in this repo under
`pages/assets/json/{grid_id}.json` — open the file and confirm the `location.full_name`
matches the region. Example: **Kankan, Guinea = `100131323`**.

## Updating a photo via the Google Cloud Console (web UI)

This is the no-install path. You only need access to the **Disciple Tools Maps** org in the
[Google Cloud Console](https://console.cloud.google.com/storage/browser/location-grid-images).

1. **Upload the image.** In the Console, navigate into
   `location-grid-images` → `v1` → `grid` → `{grid_id}` → `photos` and upload your file
   (e.g. `kankan.jpeg`). Use a simple, descriptive lowercase filename. Verify it loads:
   `https://storage.googleapis.com/location-grid-images/v1/grid/{grid_id}/photos/{filename}`

2. **Download the manifest.** Go to `location-grid-images/v1`, open `grid.json`, and
   download it.

3. **Edit the manifest.** In a text editor:
   - Find your region's entry by grid id (e.g. `"100131323"`).
   - Set its `photos` array to the file(s) you want shown, e.g. `["kankan.jpeg"]`.
     (Replace the existing entry to retire the old photo; or list multiple to rotate.)
   - Change the top-level `version` to any new number (incrementing it by 1 is fine). The
     WordPress admin uses this value to detect that an update is available.

4. **Re-upload the manifest.** Upload your edited `grid.json` back to
   `location-grid-images/v1`, **using the same filename** (`grid.json`) so it overwrites the
   old one.

5. **Verify** the live manifest reflects your change by opening
   `https://storage.googleapis.com/location-grid-images/v1/grid.json` in a browser and
   checking the `version` and your region's `photos`.

## Updating a photo via the CLI (alternative)

If you have the `gsutil` tool installed and authenticated to the org, the same steps are:

```bash
# 1. Upload the image
gsutil cp kankan.jpeg gs://location-grid-images/v1/grid/100131323/photos/kankan.jpeg

# 2. Download the manifest, edit it (set photos + bump version), then re-upload it
gsutil cp gs://location-grid-images/v1/grid.json ./grid.json
#   ...edit grid.json...
gsutil -h "Content-Type:application/json" cp ./grid.json gs://location-grid-images/v1/grid.json

# 3. Verify
curl -s https://storage.googleapis.com/location-grid-images/v1/grid.json \
  | python3 -c "import sys,json;d=json.load(sys.stdin);print(d['version'], d['100131323'])"
```

## Step A — Rebuild the WordPress image cache (required)

WordPress caches the manifest in the `pg_grid_images_json` option, so bucket changes are not
live until you rebuild that cache.

> **WP Admin → Extensions (D.T) → Prayer Global Porch → "Rebuild Grid Images Database"**

The page shows *Your Version* vs *Live Version*; when they differ it prints
`Update: YES`. Click **Rebuild Grid Images Database** to pull the fresh `grid.json` into the
option (`support/admin.php`). After this, the region serves the new photo.

If the old image still appears, it's a stale cache — clear any page/object/CDN cache for the
prayer card and re-check.

## Step B — Regenerate & republish the prayer JSON cache (required)

This is the step that actually makes the new photo appear on the prayer card. The prayer page
does **not** read the manifest at runtime. It loads a pre-built, per-region JSON file from a
separate Cloudflare R2 bucket served at
`https://s3.prayer.global/json/{language}/{grid_id}.json`. The photo URL is **baked into** that
file when it is generated (`PG_Stacker::build_location_stack()` picks a photo from the manifest
at build time), so the cache keeps serving the old image until it is regenerated and re-uploaded.

> This R2 bucket (`prayerglobal`) is **not** the same as the image bucket
> (`location-grid-images`). Different storage, different dashboard.

**1. Regenerate** the per-region JSON: open `https://prayer.global/build/json-generator`, pick
each enabled language and click **Generate** (or **Generate All**). This rebuilds every region's
JSON from the now-updated manifest into `support/build/json-files/{language}/` on the server.
Because the manifest lists only your chosen photo, the new URL gets baked in.

**2. Republish** the generated files to R2 so `s3.prayer.global` serves them, using the `rclone`
CLI on the server that holds the files (see `support/build/uploading-json-to-bucket.md`):

```bash
rclone copy ./support/build/json-files r2dt:prayerglobal/json/ -P --transfers=32 --checkers=32
# or a single language:
rclone copy ./support/build/json-files/en_US r2dt:prayerglobal/json/en_US -P --transfers=32 --checkers=32
```

**Quick one-off without regenerating everything** (mirrors the manifest edit, no CLI needed):
because only one photo URL changed, edit the cached file directly in the R2 dashboard. For
**each** language that has it (currently at least `en_US`, `fr_FR`, `pt_BR`): download
`json/{language}/{grid_id}.json`, change the `photo_block` `url` from the old filename to the new
one, and re-upload it under the same name. Verify:

```bash
curl -s https://s3.prayer.global/json/en_US/100131323.json \
  | python3 -c "import sys,json;print([b['data']['url'] for b in json.load(sys.stdin)['list'] if b['type']=='photo_block'])"
```

After republishing, allow for CDN/edge caching at `s3.prayer.global` — purge or wait out the TTL
if the old URL still appears.

## Notes

- The asset base URL is configurable: WP option `pg_fields → image_asset_url` (default
  `https://storage.googleapis.com/`), defined in `utilities/global-utilities.php`.
- `maps` is a separate image category (region map renders); leave it alone when changing
  photos.
- The prayer card reads its content from the pre-built JSON cache (Step B), **not** from the
  manifest at runtime. The manifest only feeds the build (json-generator / "Rebuild Grid Images
  Database"). A manifest change is therefore invisible on the prayer card until the JSON cache is
  regenerated and republished.
- `pages/assets/json/{grid_id}.json` is an in-repo fallback copy used if the S3 cache is
  unreachable; it also carries a baked-in photo URL. The live cache at `s3.prayer.global` is what
  matters for the running site.
