window.addEventListener("load", function ($) {
  const shareModal = document.getElementById("share-modal");
  if (!shareModal) {
    return;
  }

  window.pg_set_up_share_buttons = async function (wait = false) {
    const shareFacebook = shareModal.querySelector(".facebook-action");
    const shareTwitter = shareModal.querySelector(".twitter-action");
    const shareEmail = shareModal.querySelector(".email-action");
    const shareLink = shareModal.querySelector(".link-action");

    const metaUrlElement = document.querySelector('meta[property="og:url"]');
    const pageToShare = metaUrlElement
      ? metaUrlElement.getAttribute("content")
      : document.URL;
    const translations = window.escapeObject(window.pg_share.translations);
    const textToShare = translations["Join us in covering the world in prayer"];

    let shareButtons = [];
    shareButtons = document.querySelectorAll(".share-button");
    if (wait) {
      await new Promise((resolve) => {
        setInterval(() => {
          shareButtons = document.querySelectorAll(".share-button");
          if (shareButtons.length > 1) {
            resolve(true);
          }
        }, 100);
      });
    }

    // stop button opening modal
    shareButtons.forEach((shareButton) => {
      /* Get url, and content from button data attributes */
      const url = shareButton.getAttribute("data-url") || pageToShare;
      const content = shareButton.getAttribute("data-content") || textToShare;
      const encodedPageToShare = encodeURIComponent(url);
      const encodedTextToShare = encodeURIComponent(content);

      let button = jQuery(shareButton);
      button.off("click");
      button.on("click", () => {
        shareAction(encodedPageToShare, encodedTextToShare);

        /*         const shareFacebookAction = () => {
          const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodedPageToShare}`;
          openURL(facebookUrl);
        };
        shareFacebook.removeEventListener("click", shareFacebookAction);
        shareFacebook.addEventListener("click", shareFacebookAction); */

        const shareTwitterAction = () => {
          const twitterUrl = `https://twitter.com/intent/tweet?url=${encodedPageToShare}&text=${encodedTextToShare}&hashtags=prayerGlobal`;
          openURL(twitterUrl);
        };
        shareTwitter.removeEventListener("click", shareTwitterAction);
        shareTwitter.addEventListener("click", shareTwitterAction);

        const shareEmailAction = () => {
          const subject = "Prayer Global";
          const body = `
                ${content}
                ${url}
            `;
          const emailUrl = `mailto:?subject=${subject}&body=${body}`;
          openURL(emailUrl, { openTab: false });
        };
        shareEmail.removeEventListener("click", shareEmailAction);
        shareEmail.addEventListener("click", shareEmailAction);

        const shareLinkAction = () => {
          navigator.clipboard.writeText(url);
          shareLink.classList.add("list-group-item-success");
        };
        shareLink.removeEventListener("click", shareLinkAction);
        shareLink.addEventListener("click", shareLinkAction);

        // stop button opening modal
        button.off("click");
      });
    });

    jQuery(shareModal).on("hidden.bs.modal", () => {
      shareLink.classList.remove("list-group-item-success");
    });

    function shareAction(url, content) {
      const ctaModal = document.getElementById("cta_modal");
      if (ctaModal) {
        jQuery(ctaModal).modal("hide");
      }
      const isWebAPIShareAvailable = Object.prototype.hasOwnProperty.call(
        navigator,
        "share"
      );
      if (window.isMobileAppUser()) {
        window.location.href =
          "gonative://share/sharePage?url=" + (url ?? encodedPageToShare);
      } else if (isWebAPIShareAvailable) {
        const data = {
          url: url ?? encodedPageToShare,
        };
        navigator.share(data);
      } else {
        const navToggler = jQuery(".navbar-toggler");
        const navBar = jQuery(".pg-navmenu");
        if (navBar.hasClass("show")) {
          navToggler.click();
        }

        const myModal = new bootstrap.Modal(shareModal);
        myModal.show();
      }
    }
  };

  const openURL = (url, options = {}) => {
    const openTab = options.openTab;
    window.open(url, openTab === false ? "_self" : "_blank");
  };

  window.pg_set_up_share_buttons();
});
