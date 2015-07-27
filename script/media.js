  jQuery(document).ready(function($){
 
 
    var custom_uploader;
 
 
    $('#upload_button').click(function(e) {

        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Select Slider Images',
            button: {
                text: 'Select'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            
            //alert(JSON.stringify(custom_uploader.state().get('selection').toJSON()));
            attachment = custom_uploader.state().get('selection').toJSON();
           // $('#upload_image').val(attachment.url);
         
           
           
           $.each( attachment, function( key, md ) {
           // alert( value.url);
           
           var url = md.url;
           var id = md.id;
           var title = md.title;
           var desc = md.description;
           var link = md.link;
             
           var $data ='';
    //$data +='';
    $data += '<div class="sys_content"><input type="hidden" value="-1" name="sys_slider_items_id[]" id="sys_slider_items_id">'+'<img src="'+$close_img+'" alt="close" class="sys_close" id="remove_slider_item"/>'+'<input type="hidden" value="'+id+'" name="sys_media_id[]" id="sys_media_id" />';
    $data += '<div class="img_wrap"><img src="'+url+'" alt="'+title+'"/>';
    $data += '</div>';
    $data += '<div class="img_field">';
    $data +='<ul>';
    $data += '<li><label class="sys-cl-30">Title: </label> <input type="text" value="'+title+'"  name="sys_slider_title[]" id="sys_slider_title"/></li>';
    $data += '<li><label class="sys-cl-30">Links: </label> <input type="text" value="'+link+'"  name="sys_slider_links[]" id="sys_slider_links"/></li>';
    $data += '<li><label class="sys-cl-30">Discription:</label><textarea name="sys_slider_desc[]" id="sys_slider_desc">'+desc+'</textarea></li>';
    $data += '</ul>';
    $data +='</div><div class="clr"></div></div>';
    
           $('#slider_items_cover').append($data);
           
            });
           
           
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
 $('#remove_slider_item').live('click',function(){
      var parent = $(this).parent();
      var item_id = parent.find('input#sys_slider_items_id').val();
      
      if (item_id==-1) {
        parent.fadeOut('slow',function(){
            parent.remove();
            })
      }
      else{
        var data = {
			'action': 'delete_singsys_slider_item',
			'id': item_id
		};

	
		$.post(ajaxurl, data, function(response) {
			//alert('Got this from the server: ' + response);
                        if (response=='true') {
                            //code  
                            parent.fadeOut('slow',function(){
                            parent.remove();
                            });
                        }
                        else{
                            
                            alert(response);
                        }
		});
        
      }
      
    });
 
});
  
  
  