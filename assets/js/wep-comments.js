export default class WEP_Comments {
  static commentReplyLinkEvent() {
    document.addEventListener("DOMContentLoaded", function () {
      var commentReplyLinks = document.querySelectorAll("body.single-post #comments .comment-reply-link");
      commentReplyLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
          event.preventDefault();
          event.stopPropagation();

          var commentId = link.dataset.commentid;
          var commentContainer = link.parentElement;
          var existingQuickReply = document.getElementById("quick_reply");
          if (existingQuickReply) { existingQuickReply.remove(); }
          var quickReplyContainer = document.createElement("div");
          quickReplyContainer.id = "quick_reply";
          quickReplyContainer.style.paddingLeft = getComputedStyle(link).paddingLeft;
          quickReplyContainer.style.display = "flex";
          var inputField = document.createElement("textarea");
          inputField.classList.add(
            "form-control",
            "quick-textarea",
            "mb-2",
            "me-2"
          );
          inputField.placeholder = "Nhập bình luận của bạn...";
          quickReplyContainer.appendChild(inputField);
          var btn = document.createElement("button");
          btn.type = "button";
          btn.classList.add(
            "btn",
            "btn-sm",
            "btn-secondary",
            "custom-btn",
            "mb-2"
          );
          btn.innerHTML = "Bình luận";
          // quickReplyContainer.appendChild(btn);
          // commentContainer.appendChild(quickReplyContainer);

          var currentURL = new URL(window.location.href);
          currentURL.searchParams.set("replytocom", commentId);
          var newURL = currentURL.href;
          history.pushState({ path: newURL }, "", newURL);

          var respondTextarea = document.getElementById("comment");
          var submitBtn = document.getElementById("submit");
          var cancelBtn = document.getElementById("cr-ajax-reviews-cancel");

          inputField.focus();

          inputField.addEventListener("input", function (e) {
            if (respondTextarea) {
              respondTextarea.value = e.target.value;
            }
          });

          respondTextarea.addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
              if (respondTextarea) {
                respondTextarea.value = inputField.value;
              }
              submitBtn.click();
            } else if (e.key === "Escape") {
              if (cancelBtn) {
                cancelBtn.click();
              }
            }
          });

          inputField.addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
              if (respondTextarea) {
                respondTextarea.value = inputField.value;
              }
              submitBtn.click();
              quickReplyContainer.remove();
            } else if (e.key === "Escape") {
              quickReplyContainer.remove();
            } else {
              if (respondTextarea) {
                respondTextarea.value = inputField.value;
              }
            }
          });

          btn.addEventListener("click", function () {
            if (respondTextarea) {
              respondTextarea.value = inputField.value;
            }
            submitBtn.click();
            // quickReplyContainer.remove();
          });
        });
      });
    });

    // Include the jQuery code here directly without turning it into a method
    var jQueryCode = `
      jQuery('document').ready(function($){
          var commentform=$('body.single-post #commentform');
          commentform.prepend('<div id="comment-status" ></div>');
          var statusdiv=$('body.single-post #comment-status');

          commentform.submit(function(){
              var formdata=commentform.serialize();
              statusdiv.html('<p>Đang gửi bình luận...</p>');
              var formurl=commentform.attr('action');
              $.ajax({
                  type: 'post',
                  url: formurl,
                  data: formdata,
                  error: function(XMLHttpRequest, textStatus, errorThrown)
                      {
                          statusdiv.html('<p class="ajax-error" >Có thể bạn đã để trống một trong các trường hoặc bình luận quá nhanh.</p>');
                      },
                  success: function(data, textStatus){
                      if(data == "success" || textStatus == "success"){
                          statusdiv.html('<p class="ajax-success" >Cám ơn bạn đã bình luận.</p>');

                          // Tải lại trang sau 1 giây khi gửi bình luận thành công
                          setTimeout(function(){
                              location.reload();
                          }, 1000); // 1000 milliseconds = 1 giây
        
                          // Gọi hàm cập nhật danh sách bình luận tại đây
                          updateCommentList(commentform.find('textarea[name=comment]').val());
                      }else{
                          statusdiv.html('<p class="ajax-error" >Vui lòng đợi để gửi bình luận tiếp theo.</p>');
                          commentform.find('textarea[name=comment]').val('');
                      }
                  }
              });
              return false;
          });
      });
    `;

    // Create a script tag and append the jQuery code to it
    var script = document.createElement("script");
    script.textContent = jQueryCode;
    document.body.appendChild(script);
  }
}

// Hàm cập nhật danh sách bình luận
function updateCommentList(comment) {
  var commentList = document.getElementById("comment-list"); // Thay thế "comment-list" bằng id của danh sách bình luận thực tế của bạn
  var newComment = document.createElement("div");
  newComment.innerHTML = comment; // Thay thế "comment" bằng nội dung bình luận thực tế
  commentList.appendChild(newComment);
}

new WEP_Comments();

// Gọi hàm commentReplyLinkEvent để kích hoạt tính năng gửi bình luận
WEP_Comments.commentReplyLinkEvent();
