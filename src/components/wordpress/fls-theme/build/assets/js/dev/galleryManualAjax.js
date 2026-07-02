function initGalleryManualAjax() {
  const blocks = document.querySelectorAll("[data-gallery-manual-block]");
  if (!blocks.length) return;
  const loadTab = async (block, tabIndex) => {
    const container = block.querySelector(
      `[data-gallery-manual-content][data-tab-index="${tabIndex}"]`
    );
    if (!container) return;
    if (container.dataset.loaded === "true") return;
    if (container.dataset.loading === "true") return;
    container.dataset.loading = "true";
    const formData = new FormData();
    formData.append("action", "felgilab_load_gallery_manual_tab");
    formData.append("block_id", block.dataset.blockId);
    formData.append("post_id", block.dataset.postId);
    formData.append("tab_index", tabIndex);
    const activeButton = block.querySelector(
      `[data-gallery-manual-tab][data-tab-index="${tabIndex}"]`
    );
    formData.append("mode", block.dataset.galleryMode || "");
    formData.append("brand_id", activeButton?.dataset.brandId || "");
    formData.append("nonce", block.dataset.nonce);
    try {
      const response = await fetch("/wp-admin/admin-ajax.php", {
        method: "POST",
        body: formData,
        credentials: "same-origin"
      });
      console.log("ajax status", response.status);
      const text = await response.text();
      console.log("ajax raw response", text);
      const result = JSON.parse(text);
      console.log("ajax parsed result", result);
      if (result.success && result.data?.html) {
        container.innerHTML = result.data.html;
        container.dataset.loaded = "true";
        document.dispatchEvent(new CustomEvent("galleryTabLoaded", {
          detail: { gallery: container }
        }));
      }
    } catch (error) {
      console.error("Gallery AJAX error:", error);
    } finally {
      container.dataset.loading = "false";
    }
  };
  blocks.forEach((block) => {
    const buttons = block.querySelectorAll("[data-gallery-manual-tab]");
    const bodies = block.querySelectorAll(".gallery-tabs__body");
    buttons.forEach((button, buttonIndex) => {
      button.addEventListener("click", () => {
        buttons.forEach((btn) => btn.classList.remove("--tab-active"));
        button.classList.add("--tab-active");
        bodies.forEach((body, bodyIndex) => {
          body.hidden = bodyIndex !== buttonIndex;
        });
        loadTab(block, button.dataset.tabIndex);
      });
    });
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const activeButton = block.querySelector("[data-gallery-manual-tab].--tab-active");
        console.log("activeButton", activeButton);
        if (activeButton) {
          loadTab(block, activeButton.dataset.tabIndex);
          console.log("load first tab", activeButton.dataset.tabIndex);
        }
        obs.unobserve(block);
      });
    }, {
      rootMargin: "200px 0px",
      threshold: 0.01
    });
    observer.observe(block);
  });
}
window.addEventListener("load", initGalleryManualAjax);
