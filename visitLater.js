// JavaScript Document
var axmlHttp
function visitLater(clsno, quesid, values){
	
	axmlHttp=aGetXmlHttpObject();
	if (axmlHttp==null)
	  {
	  alert ("Your browser does not support AJAX!");
	  return;
	  } 
	//  alert(document.getElementById('visitLater_'+clsno).checked);
var radList = document.getElementsByName('ans-'+clsno);
for (var i = 0; i < radList.length; i++) {
if(radList[i].checked) radList[i].checked = false;
}
	//if(document.getElementById('qn-'+clsno).className!='ansVisitL'){
		
	document.getElementById('clear-'+clsno).style.display='none';	
	document.getElementById('qn-'+clsno).className='ansVisitL';
//	}else{
//		document.getElementById('clear-'+clsno).style.display='none';	
//		document.getElementById('qn-'+clsno).className='unsolved';
//	
//	}
	var alrtype = document.getElementById('visitLater_'+clsno).checked;
	var url="UpdateQuiz.php";
	url=url+"?quesid="+quesid;
 	url=url+"&Opts="+alrtype;
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
			
		//	 document.getElementById("Suggestions").innerHTML 		= response;

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
