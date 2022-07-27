$(document).on("submit", "#form_builder_ajax", function (e) {
  e.preventDefault();
  var images = [];
  $(".previewImg").each(function () {
    var id = $(this).attr("id");
    id = id.replace("previewImg-", "");
    var imgUrl = $(this).find("img").attr("src");
    var obj = { [id]: imgUrl };
    images.push(obj);
  });

  $.ajax({
    method: "POST",
    url: $("#ajaxURL").val(),
    data: JSON.stringify({
      id: $("#form-id").val(),
      data: $(this).serialize(),
      file: images,
    }),
    success: function (data) {
      $("#msg").html(data);
    },
  });
});

$(document).ready(function () {
  $(".uploadFile").change(function () {
    var file_data = $(this).prop("files")[0];
    var id = $(this).attr("id");
    id = "#previewImg-" + id;
    $(id).html("");

    var fileReader = new FileReader();
    fileReader.onload = function (progressEvent) {
      var url = fileReader.result;
      var img = `<div class="thumb">
                  <div class="thumb-inner">
                    <img
                      src=${url}
                      class="preview-image"
                      alt=${file_data.name}
                      data-source=${url}
                    />
                  </div>
                </div>`;
      $(id).append(img);
    };

    fileReader.readAsDataURL(file_data);
  });
});
