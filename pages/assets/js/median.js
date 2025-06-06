async function median_library_ready() {
  window.dispatchEvent(new Event("median-library-ready"));
  if (
    window.median &&
    window.median.onesignal &&
    window.median.onesignal.login
  ) {
    console.log("median and onesignal exist");

    if (pg_global.is_logged_in) {
      const notificationsPermission =
        await window.medianPermissions.getNotificationsPermission();

      if (
        notificationsPermission !== true &&
        !pg_global.has_requested_notifications
      ) {
        const setRequestedNotification = window.api_fetch(
          `${pg_global.root}pg-api/v1/user/requested-notifications`,
          {
            method: "POST",
          }
        );
        const setUserNotificationPermission = () =>
          window.api_fetch(
            `${pg_global.root}pg-api/v1/user/notifications-permission`,
            {
              method: "POST",
              body: JSON.stringify({
                notifications_permission: true,
              }),
            }
          );
        requestNotificationsPermission(
          setUserNotificationPermission,
          setRequestedNotification
        );
      }
      if (pg_global.is_logged_in && !pg_global.has_used_app) {
        window
          .api_fetch(`${pg_global.root}pg-api/v1/user/has-used-app`, {
            method: "POST",
          })
          .then(() => {
            window.pg_global.has_used_app = true;
          });
      }
    }

    if (pg_global.is_logged_in && !window.isMedianAppLoggedIn) {
      console.log("we are logged in and not logged in to median");
      try {
        await window.median.onesignal.login(pg_global.user.user_email);

        const info = await window.median.onesignal.info();
        console.log("info", info);
        window.onesignal_info = info;

        await postOneSignalData(
          info.oneSignalId,
          info.externalId,
          info.subscription.id
        ).then(() => {
          console.log("updated onesignal data");
          window.isMedianAppLoggedIn = true;
        });
      } catch (error) {
        // silently fail here, but with a message to glitchtip of the error
        console.error("Error updating onesignal data:", error);
      }
    }
  }
  function postOneSignalData(userId, externalUserId, subscriptionId) {
    return fetch(`${pg_global.root}pg-api/v1/user/onesignal`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-WP-Nonce": pg_global.nonce,
      },
      body: JSON.stringify({
        onesignal_user_id: userId || null,
        onesignal_external_id: externalUserId || null,
        onesignal_subscription_id: subscriptionId || null,
      }),
    });
  }
  if (
    window.median &&
    window.median.onesignal &&
    !window.median.onesignal.login
  ) {
    window.isLegacyAppUser = true;
  } else {
    window.isLegacyAppUser = false;
  }
}

window.requestNotifiationsPermission = requestNotificationsPermission;
function requestNotificationsPermission(
  setUserPermission,
  setNotificationRequested
) {
  const notificationModal = document.getElementById("notification-modal");
  const allowNotificationsButton = document.getElementById(
    "allow-notifications"
  );
  const dismissNotificationModal = document.getElementById(
    "dismiss-notification-modal"
  );
  const myModal = new bootstrap.Modal(notificationModal);
  myModal.show();
  allowNotificationsButton.addEventListener("click", async () => {
    window.medianPermissions.requestNotificationsPermission();

    if (window.umami) {
      window.umami.track("App - Allow notifications");
    }

    myModal.hide();

    await setUserPermission();
    await setNotificationRequested();
  });
  dismissNotificationModal.addEventListener("click", async () => {
    await setNotificationRequested();
    myModal.hide();
  });
}

function median_onesignal_push_opened(data) {
  window.umami.track("App - Push opened", {
    title: data.title,
    message: data.message,
    value: data.value,
    category: data.category,
  });
}

/* In case this JS is loaded after the median library */
if (window.median) {
  median_library_ready();
}
