function fileSelected() {
  var file = document.getElementById('videoSource').files[0];
  if (file) {
    var kb = false;
    var fileSize = 0;
    var allowedSize = Number(upload_limit); //On production server change this value to maximum allowed upload size
    if (file.size > 1024 * 1024) {
      thisSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString();
      fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
    } else {
      var kb = true;
      fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
    }

    if (!kb && thisSize > allowedSize) {
      document.getElementById('upload_btn').removeAttribute("onclick");
      document.getElementById('upload_status').innerHTML = '<div id="notice" class="text-center font-weight-bold m-3 alert alert-danger">The selected file is too large and will not be uploaded, keep it below '+allowedSize+'MB</div>';
    } else {
      document.getElementById('upload_btn').setAttribute("onclick", "uploadFile()");
      document.getElementById('upload_status').innerHTML = "";
    }

    document.getElementById('fileName').innerHTML = 'Name: ' + file.name;
    document.getElementById('fileSize').innerHTML = 'Size: ' + fileSize;
    document.getElementById('fileType').innerHTML = 'Type: ' + file.type;
  }
}

function uploadFile() {
  var fd = new FormData();
  fd.append("videoSource", document.getElementById('videoSource').files[0]);
  fd.append("module_id", document.getElementById('module_id').value); 
  var xhr = new XMLHttpRequest();
  xhr.upload.addEventListener("progress", uploadProgress, false);
  xhr.addEventListener("load", uploadComplete, false);
  xhr.addEventListener("error", uploadFailed, false);
  xhr.addEventListener("abort", uploadCanceled, false);
  xhr.open("POST", siteUrl+'/connection/upload_video.php');
  xhr.send(fd);
}

function uploadProgress(evt) {
  if (evt.lengthComputable) {
    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
    var loader = '<div class="progress" id="loader_loading"><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: '+percentComplete.toString()+'%" aria-valuenow="'+percentComplete.toString()+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
    document.getElementById('progressNumber').innerHTML = loader;
  }
  else {
    document.getElementById('progressNumber').innerHTML = 'unable to compute';
  }
}

function uploadComplete(evt) {
  /* This event is raised when the server send back a response */
  // alert(evt.target.responseText);
  var resp, ret;
  resp = JSON.parse(evt.target.responseText);
  if (resp.status == 'success') {
    var alert = 'alert-success';
    document.getElementById('iframe_major').innerHTML = '<iframe src="'+siteUrl+'/uploads/videos/'+resp.rslt+'" width="280" height="210" style="border:none; background:gray;"></iframe>';
  } else if (resp.status == 'error') {
    var alert = 'alert-danger';
  }
  var x_loader = document.getElementById('loader_loading');
  x_loader.parentNode.removeChild(x_loader);
  document.getElementById('upload_status').innerHTML = '<div class="text-center font-weight-bold m-3 alert '+alert+'">'+resp.msg+'</div>';
}

function uploadFailed(evt) {
  alert("There was an error attempting to upload the file.");
}

function uploadCanceled(evt) {
  alert("The upload has been canceled by the user or the browser dropped the connection.");
}

/**
 * Monitors the progress of an ongoing upload and displays a progress bar
 * @param  {[object]} evt  [a DOM object representing]
 * @param  {[string]} e_id [the identifier of class on which to append the progress]
 * @return {[type]}      [description]
 */
function eventProgress(evt, e_id) {
  if (evt.lengthComputable) {
    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
    var loader = '<div class="progress" id="loader_loading"><div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: '+percentComplete.toString()+'%" aria-valuenow="'+percentComplete.toString()+'" aria-valuemin="0" aria-valuemax="100"></div></div>';
    $(e_id).html(loader);
  }
  else {
    $(e_id).html('unable to compute');
  }
}


// Use croppie here
var resizes = $('#upload_resize_image');

/**
 * Handles square operations for croppie
 * @type {[object]}
 */
var vs_width  = 145; 
var vs_height = 145; 
var bs_width  = 150; 
var bs_height = 150; 

var resize = $('#croppie-image-preview').croppie({
    enableExif: true,
    enableOrientation: true,    
    viewport: { // Default { width: 100, height: 100, type: 'square' } 
      width: vs_height,
      height: vs_width,
      type: 'square' //square
    },
    boundary: {
      width: bs_height,
      height: bs_width
    }
}); 

/**
 * Handles landscape operations for croppie
 * @type {[object]}
 */

var v_wide_width  = (resizes.data('vwwidth')) ? resizes.data('vwwidth') : 425; 
var v_wide_height = (resizes.data('vwheight')) ? resizes.data('vwheight') : 255; 
var b_wide_width  = (resizes.data('bwwidth')) ? resizes.data('bwwidth') : 430; 
var b_wide_height = (resizes.data('bwheight')) ? resizes.data('bwheight') : 260;

var wideresize = $('#croppie-wide-preview').croppie({
    enableExif: true,
    enableOrientation: true,    
    viewport: { // Default { width: 100, height: 100, type: 'square' } 
      width: v_wide_width,
      height: v_wide_height,
      type: 'square' //square
    },
    boundary: {
      width: b_wide_width,
      height: b_wide_height,
    }
});

/**
 * Detects if there is a change in the image select input, then triggers croppie
 * @param  {[String]} ) {             var endpoint_id [the id of the user or contest receiving the upload]
 * @param  {[String]} ) {             var endpoint [the endpoint receiving the upload could either be a user or a contest]
 * @return {[string]}   [null]
 */
$('.image-selection').on('change', function () {

  var _identifier = $('#button_identifiers').val();
  if (typeof _identifier === 'undefined' || _identifier == '') {
    var _identifier = 'upload_resize_image';
  }
  var endpoint_id = $('#' + _identifier).data('endpoint_id');
  var endpoint    = $('#' + _identifier).data('endpoint');
  var preset_type = $('#' + _identifier).data('set_type');
  var extra_data  = $('#' + _identifier).data('data');
  var set_type    = (typeof preset_type !== 'undefined') ? preset_type : '1';

  var new_attr = 'upload_action('+set_type+(endpoint_id ? ', \''+endpoint_id+'\'' : '') + (endpoint ? ', \''+endpoint+'\'' : '') + (extra_data ? ',' + extra_data : '') + ')'; 

  var upload_type = $(this).attr('id');
  if (upload_type == 'image-input') {
    var resized = resize;
    var image_size = 'image';
  } else {
    var resized = wideresize;
    var image_size = 'wide';
    $('.btn-upload-image').attr('onclick', new_attr);
  }

  $('#croppie-'+image_size+'-preview').show();
  $('.image-selection-label').hide();
  $('#image-input-label').hide();
  $('.btn-upload-image').show();

  var reader = new FileReader();

  reader.onload = function (e) {
    resized.croppie('bind',{
      url: e.target.result
    }).then(function(){
      console.log('jQuery bind complete'); 
    });
  }

  reader.readAsDataURL(this.files[0]);

});

/**
 * Takes an image processed by croppie and uploads it to the server
 * @param  {[String]} type     [when type = 0 the avatar image will be changed and when type = 1 the cover photo will be changed]
 * @param  {[String]} id       [the id of the endpoint receiving this upload]
 * @param  {[String]} endpoint [var endpoint [the endpoint receiving the upload could either be a user or a contest]]
 * @return {[string]}   [null]
 */
function upload_action(type, id, endpoint, extra) { 
  
  // $('.btn-upload-image').html(spinner(1, 4, 2, 1));
  var m_id = '#uploaded-image-preview'; 
  $("#action-buttons").hide();

  if (type == 1) {
    var set_type   = 'cover';
    var resized    = wideresize;
    var image_size = 'wide';
  } else {
    var set_type   = 'square';
    var resized    = resize;
    var image_size = 'image';
  }

  if (type == 3 || type == 4) {
    var set_type   = endpoint;
    var resized    = (type == 3) ? wideresize : resize;
    var image_size = (type == 3) ? 'wide' : 'image';
  }

  var query = (id ? '/'+id : '') + (endpoint ? '/'+endpoint : '');
 
  resized.croppie('result', {
    type: 'canvas',
    size: {
      width: 2000
    }
  }).then(function (img) {
    if (endpoint == 'pop') {
      var channel = $("#action-buttons").find('#channel').val();
      var bank    = $("#action-buttons").find('#bank_code').val();
      var set_data = {ajax_image:img, set_type:set_type, channel:channel, bank_code:bank, data:extra};
    } else {
      var set_data = {ajax_image:img, set_type:set_type, data:extra};
    }
 
    $.ajax({
      url: link('connect/upload_image'+query),
      type: "POST",
      data: set_data,
      dataType: "JSON",
      xhr: function () {
        var xhr = $.ajaxSettings.xhr(); 
        xhr.upload.onprogress = function (e) {
          // For uploads
          eventProgress(e, '#upload-status');
        };
        return xhr;
      }
    }).done(function (data) {
      html = img.length > 10 ? '<div class="d-flex container justify-content-center"><img src="' + img + '" height="250px" width="auto"/></div>' : '';
      if (img.length > 10) {
        $('img.'+endpoint).attr('src', img);
      }
      $(m_id).html(html);
      if (data.error) {
        $("#upload-status").html(data.error);
      } else {
        $("#upload-status").html(data.success);
      }
      
      $("#croppie-"+image_size+"-preview").hide(); 
    }).fail(function (e) {
      error_message(e, e.status, e.status, m_id);
    });
  }); 
}  
