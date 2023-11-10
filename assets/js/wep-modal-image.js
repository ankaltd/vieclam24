export default class ImageModal {
  constructor() {
    this.modal = this.createModal();
    document.body.appendChild(this.modal);
    this.images = Array.from(
      document.querySelectorAll(".wep_content_html img")
    );
    this.currentImageIndex = null;
  }

  createModal() {
    const modal = document.createElement("div");
    modal.id = "modal";
    modal.style.display = "none";
    modal.style.position = "fixed";
    modal.style.zIndex = "99999";
    modal.style.left = "0";
    modal.style.top = "0";
    modal.style.width = "100%";
    modal.style.height = "100%";
    modal.style.overflow = "auto";
    modal.style.backgroundColor = "rgba(0,0,0,0.4)";

    const closeButton = document.createElement("span");
    closeButton.innerHTML = "×";
    closeButton.style.position = "absolute";
    closeButton.style.top = "10px";
    closeButton.style.right = "10px";
    closeButton.style.color = "#f1f1f1";
    closeButton.style.fontSize = "40px";
    closeButton.style.fontWeight = "bold";
    closeButton.style.transition = "0.3s";
    closeButton.style.cursor = "pointer";
    closeButton.className = "close";
    modal.appendChild(closeButton);

    const prevButton = document.createElement("span");
    prevButton.innerHTML = "❮";
    prevButton.style.cursor = "pointer";
    prevButton.style.position = "absolute";
    prevButton.style.top = "50%";
    prevButton.style.width = "auto";
    prevButton.style.padding = "16px";
    prevButton.style.marginTop = "-50px";
    prevButton.style.color = "white";
    prevButton.style.fontWeight = "bold";
    prevButton.style.fontSize = "20px";
    prevButton.style.transition = "0.6s ease";
    prevButton.style.borderRadius = "0 3px 3px 0";
    prevButton.style.userSelect = "none";
    prevButton.className = "prev";
    modal.appendChild(prevButton);

    const nextButton = document.createElement("span");
    nextButton.innerHTML = "❯";
    nextButton.style.cursor = "pointer";
    nextButton.style.position = "absolute";
    nextButton.style.top = "50%";
    nextButton.style.width = "auto";
    nextButton.style.padding = "16px";
    nextButton.style.marginTop = "-50px";
    nextButton.style.color = "white";
    nextButton.style.fontWeight = "bold";
    nextButton.style.fontSize = "20px";
    nextButton.style.transition = "0.6s ease";
    nextButton.style.borderRadius = "0 3px 3px 0";
    nextButton.style.userSelect = "none";
    nextButton.style.right = "0";
    nextButton.className = "next";
    modal.appendChild(nextButton);

    const img = document.createElement("img");
    img.className = "modal-content";
    img.id = "img01";
    img.style.margin = "auto";
    img.style.display = "block";
    img.style.width = "auto";
    img.style.height = "auto";
    img.style.maxWidth = "90%";
    img.style.top = "50%";
    img.style.left = "50%";
    img.style.position = "absolute";
    img.style.transform = "translate(-50%, -50%)";
    modal.appendChild(img);

    return modal;
  }

  openModal(imageSrc) {
    const img = this.modal.querySelector("img");
    img.src = imageSrc;
    this.modal.style.display = "block";
    this.currentImageIndex = this.images.findIndex(
      (image) => image.src === imageSrc
    );
  }

  closeModal() {
    this.modal.style.display = "none";
  }

  showPrevImage() {
    if (this.currentImageIndex > 0) {
      this.currentImageIndex--;
      this.openModal(this.images[this.currentImageIndex].src);
    }
  }

  showNextImage() {
    if (this.currentImageIndex < this.images.length - 1) {
      this.currentImageIndex++;
      this.openModal(this.images[this.currentImageIndex].src);
    }
  }

  attachImageClickHandler(imageElement) {
    imageElement.style.cursor = "pointer";
    imageElement.addEventListener("click", () =>
      this.openModal(imageElement.src)
    );
  }

  attachModalClickHandler() {
    const closeBtn = this.modal.querySelector(".close");
    closeBtn.addEventListener("click", () => this.closeModal());
    this.modal.addEventListener("click", (event) => {
      if (event.target == this.modal) {
        this.closeModal();
      }
    });
    const prevBtn = this.modal.querySelector(".prev");
    prevBtn.addEventListener("click", () => this.showPrevImage());
    const nextBtn = this.modal.querySelector(".next");
    nextBtn.addEventListener("click", () => this.showNextImage());
    window.addEventListener("keydown", (event) => {
      if (event.key === "Escape") {
        this.closeModal();
      } else if (event.key === "ArrowLeft") {
        this.showPrevImage();
      } else if (event.key === "ArrowRight") {
        this.showNextImage();
      }
    });
  }

  init() {
    this.images.forEach((image) => this.attachImageClickHandler(image));
    this.attachModalClickHandler();
  }
}


// Modal img cho news content
const imageModal = new ImageModal();
imageModal.init();