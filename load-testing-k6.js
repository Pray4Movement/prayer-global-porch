import http from "k6/http";
import { sleep } from "k6";

const debug = false;
export const options = {
  scenarios: {
    /*     redirect_and_update_cloud: {
      executor: "ramping-arrival-rate",
      startTime: "0s",
      timeUnit: "1s",
      startRate: 0,
      stages: [{ duration: "15s", target: 1000 }],
      preAllocatedVUs: 50,
      maxVUs: 100,
    }, */
    constant_rate: {
      executor: "constant-arrival-rate",
      duration: "300s",
      rate: debug ? "1" : "17",
      timeUnit: debug ? "30s" : "1s",
      preAllocatedVUs: 50,
      maxVUs: 500,
    },
  },
};

const relayKey = "014d9d";
const relayId = "1355";
const origin = "http://localhost:8000";
const apiHost = `${origin}/wp-content/plugins/prayer-global-porch/`;

export default function () {
  const response = http.get(
    `${apiHost}next-location.php?relay_key=${relayKey}`,
    {
      headers: {
        Origin: origin,
        Cookie: debug ? "XDEBUG_SESSION=XDEBUG_ECLIPSE;" : "",
      },
      tags: {
        test_type: "next-location",
      },
    }
  );

  if (response.status !== 200) {
    console.error("Failed to get next location", response);
    return;
  }
  const body = JSON.parse(response.body);
  const locationId = body.next_location;

  if (debug) {
    console.log(response.body, locationId);
  }

  http.post(
    `${apiHost}update-location.php`,
    JSON.stringify({
      user_id: 7,
      grid_id: locationId,
      relay_key: relayKey,
      relay_id: relayId,
      pace: "1",
      parts: {
        root: "prayer_app",
        type: "custom",
        meta_key: "prayer_app_custom_magic_key",
        public_key: relayKey,
        action: "",
        post_id: relayId,
        post_type: "pg_relays",
        instance_id: "",
      },
      user_location: {
        lng: "-1.886317",
        lat: "52.489988",
        level: "district",
        label: "West Midlands, England, United Kingdom",
        source: "user",
        grid_id: "100130669",
        country: "United Kingdom",
        hash: "297ccde23b113613a1d3df3cf56bb120d6510dcb4e012713b671936f938f7c1f",
      },
    }),
    {
      headers: {
        Origin: origin,
        Cookie: debug ? "XDEBUG_SESSION=XDEBUG_ECLIPSE;" : "",
      },
      tags: {
        test_type: "updates",
      },
    }
  );
}
