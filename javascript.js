
function download(url) {
    document.getElementById("fileFrame").document.location = url;
	alert();
}


function populateIframe(id,path) 
{
    var ifrm = document.getElementById(id);
    ifrm.src = "download.php?path="+path;
}