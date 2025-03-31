window.MedianPermissions = MedianPermissions;
class MedianPermissions {
  medianLibraryReady = false;
  hasOnesignal = false;

  constructor() {
    this.permissions = [];
    window.addEventListener("median-library-ready", () => {
      this.init();
    });
    if (window.median) {
      this.init();
    }
  }

  init() {
    this.medianLibraryReady = true;
    if (window.median.onesignal) {
      this.hasOnesignal = true;
    }
  }

  async getPermissions() {
    const response = await window.median.permissions.status();
    return response;
  }

  /**
   * Get the status of a permission
   * @param {string} permission - The permission to get the status of
   * @returns {boolean|null} - Returns true if the permission is granted, false if denied, and null if not yet determined
   */
  async getPermissionStatus(permission) {
    const response = await this.getPermissions();

    if (response[permission] === "granted") {
      return true;
    }
    if (response[permission] === "denied") {
      return false;
    }
    return null;
  }

  /**
   * Get the status of the notifications permission
   * @returns {boolean|null} - Returns true if the permission is granted, false if denied, and null if not yet determined
   */
  async getNotificationsPermission() {
    return this.getPermissionStatus("Notifications");
  }

  requestNotificationsPermission() {
    window.median.onesignal.register();
  }
}
