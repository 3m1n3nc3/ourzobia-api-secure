            <?php if (!empty($profile['uid']) && user_id() == $profile['uid']): ?>      
            <div class="d-flex justify-content-around mb-2">                    
                <div id="upload_resize_image" 
                    data-endpoint="avatar" 
                    data-endpoint_id="<?=$profile['uid']; ?>" 
                    class="d-none" style="display:none;"> 
                </div>

                <div class="btn btn-warning btn-lg upload_resize_image"
                    id="resize_image_button"  
                    data-modal-title = "Upload Profile Photo" 
                    data-type="square" 
                    data-endpoint="avatar"
                    data-endpoint_id="<?=$profile['uid']?>" 
                    data-toggle="modal" 
                    data-target="#uploadModal">
                    <i class="feather icon-camera"></i> 
                    Change Profile Photo 
                </div>
                
                <div id="upload_resize_cover" 
                    data-endpoint="cover" 
                    data-endpoint_id="<?=$profile['uid']; ?>" 
                    class="d-none" style="display:none;"> 
                </div>
                <div class="btn btn-info btn-lg upload_resize_image"
                    id="resize_cover_button"  
                    data-modal-title = "Upload Cover Photo" 
                    data-type="wide" 
                    data-endpoint="cover"
                    data-endpoint_id="<?=$profile['uid']?>" 
                    data-toggle="modal" 
                    data-target="#uploadModal">
                    <i class="feather icon-image"></i> 
                    Change Cover Photo  
                </div> 
            </div>
            <hr>
            <?php endif ?>      