import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
  scenarios: {
/*     redirect_and_update: {
      executor: 'ramping-arrival-rate',
      startTime: '0s',
      timeUnit: '1s',
      startRate: 0,
      stages: [
        { duration: '15s', target: 2000 },
      ],
      preAllocatedVUs: 500,
      maxVUs: 4000,
    }, */
    redirect_and_update_cloud: {
      executor: 'ramping-arrival-rate',
      startTime: '0s',
      timeUnit: '1s',
      startRate: 0,
      stages: [
        { duration: '15s', target: 100 },
      ],
      preAllocatedVUs: 50,
      maxVUs: 100,
    }
  }
};

const relay = 'f176ba'
const apiHost = 'https://api.prayer.global'
const domain = 'perf.prayer.global'

export default function() {
  const response = http.get(`${apiHost}?relay=${relay}&domain=${domain}`, {
    redirects: 0,
    tags: {
      test_type: 'redirects'
    }
  });

  const locationId = response.headers['X-Location-Grid-Id']

  http.post(`${apiHost}/update?location=${locationId}&relay=${relay}`, {
    tags: {
      test_type: 'updates'
    }
  })
}
