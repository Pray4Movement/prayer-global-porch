from locust import HttpUser, task

class RedirectingUser(HttpUser):
    host="https://api.prayer.global"

    relay="0f6263"

    @task
    def pray_for_location(self):
        self.client.get(f"/?relay={self.relay}&domain=perf.prayer.global")

class PrayingUser(HttpUser):
    host="https://api.prayer.global"

    relay="0f6263"

    @task
    def pray_for_location(self):
        response = self.client.get(f"/?relay={self.relay}&domain=perf.prayer.global")
        redirect = response.url
        locationID = redirect.split('=')[1]

        self.client.post(f"/update?location={locationID}&relay={self.relay}", name='/update')