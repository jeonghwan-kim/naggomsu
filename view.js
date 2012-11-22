

var currentPos = 0;

// 문서 로딩시 호출 
window.onload = function() {
	loadRssItems(15); // 2개 rss 항목 로딩
}

// rss 항목 로딩하는 함수 (pos부터 size개만큼 로딩함)
function loadRssItems(num) {
	var xmlhttp = new XMLHttpRequest();
	// makeXml.php 호출
	xmlhttp.open("get", "makeXml.php?start=" + currentPos + "&end=" + (currentPos+num-1), true);
	currentPos = currentPos + num;
	xmlhttp.send();
	xmlhttp.onreadystatechange = function() {		
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			// naggomsu.xml 호출
			xmlhttp.open("get", "naggomsu.xml", true);
			xmlhttp.send();
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					// 화면에 출력 
					var entries = xmlhttp.responseXML.getElementsByTagName("entry");
					for (var i = 0; i < entries.length; i++) {
						var title = getText(entries[i].getElementsByTagName("title")[0]);
						var subtitle = getText(entries[i].getElementsByTagName("subtitle")[0]);
						var audio_url = getText(entries[i].getElementsByTagName("audio_url")[0]);
						document.getElementById("list").innerHTML += "<li>" + title + " - " 
						+ subtitle + "<a href='" + audio_url+ "'>Download</a>" + "</li>";
					}
				}
			}
		}
	}
}

// element 로 부터 nodeValue 얻어내는 함수
// 없으면 "" 반환
function getText(elem) {
    var text = "";
    if (elem) {
        if (elem.childNodes) {
            var child = elem.childNodes[0];
            if (child && child.nodeValue) text = child.nodeValue;
        }
    }
    return text;
}

// more 버튼 클릭시 콜백함수
function more() {
	loadRssItems(20);
}









