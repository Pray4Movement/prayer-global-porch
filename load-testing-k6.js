import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
  scenarios: {
    redirect_and_update: {
      executor: 'ramping-arrival-rate',
      startTime: '0s',
      timeUnit: '1s',
      startRate: 0,
      stages: [
        { duration: '5s', target: 2000 },
        { duration: '5s', target: 0 },
/*         { duration: '53s', target: 0 },
        { duration: '10s', target: 2000 },
        { duration: '10s', target: 0 }, */
      ],
      preAllocatedVUs: 500,
      maxVUs: 4000,
    }
  }
};

const relay = 'dbd28'
const apiHost = 'https://api.prayer.global?domain=perf.prayer.global'
const waitTime = 30

/* Simulate a user being redirected and then logging between 30-60 seconds */
export default function() {
  const response = http.get(`${apiHost}?relay=${relay}`, {
    redirects: 0,
    tags: {
      test_type: 'redirects'
    }
  });

  const url = response.url

  const locationId = url.split('=').pop()

  const randomWait = waitTime + Math.floor( Math.random() * waitTime )

/*   sleep(randomWait)

  http.post(`${apiHost}/update?location=${locationId}&relay=${relay}`, {
    tags: {
      test_type: 'updates'
    }
  })

  sleep(( 2 * waitTime) - randomWait ) */
}
