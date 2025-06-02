jQuery(document).ready(() => {
  mapbox_border_map();
});

/**
 * Maps
 */
function mapbox_border_map() {
  let content = jQuery("#location-map");
  let grid_row = jsObject.location;

  content.empty().html(`
      <div id="map-wrapper">
        <div id='mapbox-map' style="border-radius: 0"></div>
      </div>
      `);

  window.load_map_with_style = () => {
    if (typeof mapboxgl === "undefined") {
      return;
    }
    let center = [grid_row.p_longitude, grid_row.p_latitude];
    mapboxgl.accessToken = jsObject.map_key;
    let map = new mapboxgl.Map({
      container: "mapbox-map",
      style: "mapbox://styles/discipletools/clgnj6vkv00e801pj9xnw49i6",
      center: center,
      minZoom: 0,
      zoom: 1,
      zoomControls: false,
    });
    map.dragRotate.disable();
    map.touchZoomRotate.disableRotation();

    map.on("load", function () {
      jQuery
        .ajax({
          url:
            jsObject.mirror_url +
            "collection/" +
            grid_row.parent_id +
            ".geojson",
          dataType: "json",
          data: null,
          cache: true,
          beforeSend: function (xhr) {
            if (xhr.overrideMimeType) {
              xhr.overrideMimeType("application/json");
            }
          },
        })
        .done(function (geojson) {
          /* Make sure that grid_id properties are strings to enable correct filtering for red fill */
          /* TODO: fix any geojson files that have integers as their grid_id properties and convert them to strings */
          if (
            geojson.features.length > 0 &&
            typeof geojson.features[0].properties.grid_id === "number"
          ) {
            geojson.features.forEach((feature, i) => {
              geojson.features[
                i
              ].properties.grid_id = `${feature.properties.grid_id}`;
            });
          }

          map.addSource("parent_collection", {
            type: "geojson",
            data: geojson,
          });
          map.addLayer({
            id: "parent_collection_lines",
            beforeId: "poi-labels",
            type: "line",
            source: "parent_collection",
            paint: {
              "line-color": "#6e6f70",
              "line-width": 2,
            },
          });
          map.addLayer({
            id: "parent_collection_fill",
            beforeId: "poi-labels",
            type: "fill",
            source: "parent_collection",
            filter: ["==", ["get", "grid_id"], grid_row.grid_id],
            paint: {
              "fill-color": "#fff",
              "fill-opacity": 1,
            },
          });
          map.addLayer({
            id: "parent_collection_fill_click",
            beforeId: "poi-labels",
            type: "fill",
            source: "parent_collection",
            paint: {
              "fill-color": "white",
              "fill-opacity": 0,
            },
          });

          console.log(map);

          let point_geojson = {
            type: "FeatureCollection",
            features: [
              {
                type: "Feature",
                properties: {
                  full_name: grid_row.full_name,
                },
                geometry: {
                  type: "Point",
                  coordinates: [grid_row.longitude, grid_row.latitude],
                },
              },
            ],
          };
          map.addSource("point_geojson", {
            type: "geojson",
            data: point_geojson,
          });
          map.addLayer({
            id: "poi-labels",
            type: "symbol",
            source: "point_geojson",
            layout: {
              "text-field": ["get", "full_name"],
              "text-variable-anchor": ["top", "bottom", "left", "right"],
              "text-radial-offset": 0.5,
              "text-justify": "auto",
              "text-allow-overlap": false,
              "text-size": 26,
            },
            paint: {
              "text-color": "#202",
              "text-halo-color": "#dbe9f4",
              "text-halo-width": 3,
            },
          });

          map.moveLayer("poi-labels");

          const paddingBoundary = 500 * 0.2;
          const padding = {
            top: paddingBoundary,
            bottom: paddingBoundary,
            left: 315 + paddingBoundary,
            right: 315 + paddingBoundary,
          };

          map.fitBounds(
            [
              [
                parseFloat(grid_row.p_west_longitude),
                parseFloat(grid_row.p_south_latitude),
              ], // southwestern corner of the bounds
              [
                parseFloat(grid_row.p_east_longitude),
                parseFloat(grid_row.p_north_latitude),
              ], // northeastern corner of the bounds
            ],
            { padding: padding, duration: 0 }
          );
        });

      if (grid_row.level >= 2) {
        jQuery
          .ajax({
            url:
              jsObject.mirror_url +
              "low/" +
              grid_row.admin0_grid_id +
              ".geojson",
            dataType: "json",
            data: null,
            cache: true,
            beforeSend: function (xhr) {
              if (xhr.overrideMimeType) {
                xhr.overrideMimeType("application/json");
              }
            },
          })
          .done(function (geojson) {
            map.addSource("country_outline", {
              type: "geojson",
              data: geojson,
            });
            map.addLayer({
              id: "country_outline_lines",
              type: "line",
              source: "country_outline",
              paint: {
                "line-color": "#6e6f70",
                "line-width": 4,
              },
            });

            map.moveLayer("country_outline_lines", "poi-labels");
          });
      }
    }); // map load
  };
  window.load_map_with_style(); // initialize map
}
