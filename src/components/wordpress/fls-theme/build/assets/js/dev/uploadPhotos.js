document.addEventListener("DOMContentLoaded", () => {
  const fileInput = document.getElementById("wheel_photos");
  const fileList = document.getElementById("fileList");
  if (!fileInput || !fileList) return;
  fileInput.addEventListener("change", () => {
    fileList.innerHTML = "";
    if (!fileInput.files.length) return;
    Array.from(fileInput.files).forEach((file) => {
      const item = document.createElement("div");
      item.className = "file-item";
      item.textContent = file.name;
      fileList.appendChild(item);
    });
  });
});
