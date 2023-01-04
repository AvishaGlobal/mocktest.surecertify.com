// JavaScript Document
var axmlHttp
function clearData(clsno, quesid){
	
	axmlHttp=aGetXmlHttpObject();
	if (axmlHttp==null)
	  {
	  alert ("Your browser does not support AJAX!");
	  return;
	  } 
var radList = document.getElementsByName('ans-'+clsno);
for (var i = 0; i < radList.length; i++) {
if(radList[i].checked) radList[i].checked = false;
}
	document.getElementById('clear-'+clsno).style.display='none';	
	document.getElementById('qn-'+clsno).className='unsolved';
	document.getElementById('visitLater_'+Sno).checked=false;
	var url="ClearQuiz.php";
	url=url+"?quesid="+quesid;
 	url=url+"&sid="+Math.random();
	// alert(url);
	axmlHttp.onreadystatechange=stateChangeda;
	axmlHttp.open("GET",url,true);
	axmlHttp.send("UsernmaeSuggestions");
	
}

function stateChangeda() 
{ 
	 
	if (axmlHttp.readyState==4){ 
		//document.getElementById(tdid).innerHTML=xmlHttp.responseText;
		 
		if (axmlHttp.status == 200){
       		
			var response = axmlHttp.responseText;
			
			// document.getElementById("Suggestions").innerHTML 		= response;

			}
		
		}

	}

 
function aGetXmlHttpObject()
{
var mxmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  mxmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    mxmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    mxmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return mxmlHttp;
}
