// Get all ID with trackThis class

const sectionElements = document.querySelectorAll(".trackThis");

const sectionIds = [];



sectionElements.forEach((element) => {

  sectionIds.push(element.id);

});



// Check id for create progress for section

let stt = 0;

let progressSection = document.getElementById("progress-section");

let currentSectionId = sectionIds[stt];

let wepSection = document.getElementById(currentSectionId);

let targetSection = document.querySelectorAll(".target_" + currentSectionId);

let allTarget = document.querySelectorAll(".wep_goto_section__item span");



const setProgressSection = () => {

  let sectionTop = wepSection.offsetTop - 200; // Tọa độ top của phần tử wep_about, wep_history,...

  let progressWidth = (window.pageYOffset - sectionTop) / 10; // Độ rộng thanh tiến trình

  let progressWidthGreat = progressWidth;



  // Giới hạn độ rộng thanh tiến trình từ 0 đến 100

  progressWidth = Math.max(0, Math.min(progressWidth, 100));

  // progressSection.style.width = progressWidth + "%"; // for Over page



  // Duyệt qua tất cả các thành phần

  // Set to target section - Vòng lặp qua từng thành phần và đặt thuộc tính độ rộng

  targetSection.forEach((element) => {

    element.style.width = progressWidth + "%"; // Thay đổi giá trị độ rộng theo mong muốn

  });



  // Kiểm tra nếu progressWidth vượt quá giới hạn

  if (progressWidthGreat >= 100) {

    stt++;

    if (stt >= sectionIds.length) {

      stt = sectionIds.length - 1;

    }



    // Update Section

    updateSection();



    removeAllActive();

  } else if (progressWidthGreat < 0) {

    stt--;

    if (stt < 0) {

      stt = 0;

    }



    // Update Section

    updateSection();

  }

};



// Update Section position when scroll

function updateSection() {

  // Set new section

  currentSectionId = sectionIds[stt];

  wepSection = document.getElementById(currentSectionId);

  targetSection = document.querySelectorAll(".target_" + currentSectionId);



  // Reset prev item

  allTarget.forEach((element) => {

    element.style.width = "0%"; // Thay đổi giá trị độ rộng theo mong muốn

  });

}



// Event Scroll

if (progressSection && sectionIds.length > 0 && wepSection) {

  window.addEventListener("scroll", setProgressSection);

}



// Remove all .active class

function removeAllActive() {

  // Xóa lớp .active khỏi tất cả các thẻ span

  var allSpans = document.querySelectorAll(".wep_goto_section__item span");

  allSpans.forEach(function (span) {

    span.classList.remove("active");

  });

}



// Update when click - Lấy danh sách các thẻ a

var links = document.querySelectorAll('a[href^="#wep_"]');



// Duyệt qua từng thẻ a và gán sự kiện click

links.forEach(function (link) {

  link.addEventListener("click", function () {

    // Lấy vị trí của thẻ a trong danh sách

    // var position = Array.from(links).indexOf(link);



    // Xóa lớp .active khỏi tất cả các thẻ span

    removeAllActive();



    // Lấy giá trị của thuộc tính class của thẻ span bên trong thẻ a

    var spanClass = link.querySelector("span").className;



    // Reset prev item

    allTarget.forEach((element) => {

      element.style.width = "0%"; // Thay đổi giá trị độ rộng theo mong muốn

    });



    // Thêm lớp .active vào thành phần có tên lớp tương ứng

    var elementWithClass = document.querySelector("." + spanClass);

    if (elementWithClass) {

      elementWithClass.classList.add("active");

    }

  });

});

