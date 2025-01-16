import http from "k6/http";
import { sleep } from "k6";

export const options = {
  scenarios: {
    redirect_and_update_cloud: {
      executor: "ramping-arrival-rate",
      startTime: "0s",
      timeUnit: "1s",
      startRate: 0,
      stages: [{ duration: "1m", target: 100 }],
      preAllocatedVUs: 200,
      maxVUs: 2000,
    },
  },
};

const apiHost = "https://staging.prayer.global/wp-json/prayer_app/v1/global";
const data = {
  action: "refresh",
  parts: {
    root: "prayer_app",
    type: "global",
    meta_key: "prayer_app_global_magic_key",
    public_key: "49ba4c",
    action: "",
    post_id: "1966",
    post_type: "laps",
    instance_id: "",
  },
  data: { grid_id: null },
};

export default function () {
  http.post(apiHost, JSON.stringify(data), {
    headers: {
      "X-WP-Nonce": "3c631cff67",
      Cookie:
        "wp-settings-7=posts_list_mode%3Dlist; wp-settings-time-7=1736420744; dt-magic-link-lang=en_US; wordpress_test_cookie=WP%20Cookie%20check; wordpress_logged_in_c7b8e480d09cc629b7cda10e191801ee=nathinabob%40gmail.com%7C1768301952%7CL3BVRMpASXZTjKm8dVXkkkiWFCYe3yex0hw1oxz17iN%7Cca8bda27c53f316bef47dba43c3c34aa57e4482d6f238e54509a601f5853bd36",
      "Content-Type": "application/json",
    },
  });
}
