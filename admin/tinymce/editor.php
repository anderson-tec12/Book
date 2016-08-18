<script>
function initEditor ( id,  width, height ){
	
	var p_width = "99%";
	var p_height = "200";
	
	if ( width != null )
		p_width = width;
	
	
	if ( height != null )
		p_height = height;
	
	
	tinymce.init({
	
	language : 'pt_BR',
        
            relative_urls : false,
            remove_script_host : true,
            convert_urls : true,
        
    selector: "#"+id,theme: "modern",width: p_width,height: p_height,
	
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen textcolor",
		"insertdatetime media table contextmenu paste jbimages responsivefilemanager"
		],
	
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
   toolbar2: "| jbimages | responsivefilemanager |  link unlink anchor | image media | forecolor backcolor fontsizeselect  | print preview code ",
   image_advtab: true ,
   
   
   external_filemanager_path:"<?=K_RAIZ?>tinymce/responsive_filemanager/filemanager/",
   filemanager_title:"Gerenciar Arquivos" ,
   external_plugins: { "filemanager" : "<?=K_RAIZ?>tinymce/plugins/responsivefilemanager/plugin.min.js"}
 });
	
	
}

function initEditorSimple ( id,  width, height ){
	
	var p_width = "99%";
	var p_height = "200";
	
	if ( width != null )
		p_width = width;
	
	
	if ( height != null )
		p_height = height;
	
	
	tinymce.init({
	
	language : 'pt_BR',
        
            relative_urls : false,
            remove_script_host : true,
            convert_urls : true,
            extended_valid_elements:'script[language|type|src]',
        
        
        selector: "#"+id,theme: "modern",width: p_width,height: p_height,
	
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen textcolor",
		"insertdatetime media table contextmenu paste jbimages responsivefilemanager"
		],
	
             menubar: false,
   toolbar1: "undo redo | jbimages responsivefilemanager | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect code",
   //toolbar2: "| jbimages | responsivefilemanager |  link unlink anchor | image media | forecolor backcolor  | print preview | code ",
   image_advtab: true ,
   
   
   external_filemanager_path:"<?=K_RAIZ?>tinymce/responsive_filemanager/filemanager/",
   filemanager_title:"Gerenciar Arquivos" ,
   external_plugins: { "filemanager" : "<?=K_RAIZ?>tinymce/plugins/responsivefilemanager/plugin.min.js"}
   
 });
	
	
}

 
</script>