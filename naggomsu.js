// variables
var currentItemNum = 0; // 현재 아이템 번호
var itemsPerTime = 10;  // 한번에 보여줄 아이템 갯수 (more 버튼과 관련)
var animationCount = 0; // 버튼 클릭후 애니매이션 기능과 관련
var timerID;    // 애니메이션 동작시 타이머 id

// 아이템을 itemPerTime개 만큼 보여준다.
function showItem() {
    // 객체의 스타일 속성을 block으로 지정 
    // html 객체가 로딩되어 있으나 스타일 속성이 none으로 되어있어 보이지 않을 뿐임
    if (!document.getElementById(currentItemNum)) {
        document.getElementsByTagName("input")[0].style.display = "none";
        return; // 더이상 객체가 없을 경우
    } else { 
        document.getElementById(currentItemNum).style.display = "block"; // default:"none"
    }

    // 홀수 row: FFFFFF, 짝수 row: F8F8F8
    if (currentItemNum % 2) { // 짝수
        document.getElementById(currentItemNum).style.background = "#F8F8F8";
    } else { // 홀수
        document.getElementById(currentItemNum).style.background = "#FFFFFF";
    }
    
    currentItemNum++;

// itemsPerTime개 만큼 보였줬으면 타이머 종료
    if (++animationCount >= itemsPerTime) { 
        clearInterval(timerID);
        animationCount = 0;				
    }			
}   		

// more 버튼 콜백함수 (animation show)
function more() {
    timerID = setInterval(function() {
        showItem();
        }, 50);		
}

// html 로딩시 more 함수 동작
window.onload = more; 