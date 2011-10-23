//Create a bolean variable to check for a valid IE instanceof
var xmlhttp = false;
//check if we are using IE
try
{
	//if javascrip version is greater than 5.
	xmlhttp =  new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e)
{
	//if not, then use the older activex object
	try
	{
		//if we are using IE
		xmlhttp = new ActiveXObject("Microsoftt.XMLHTTP");
	}
	catch(E)
	{
		//Else we must be using non-IE browser
		xmlhttp=false;
	}
}

//if we are sing a non IE browser create a javascript instance of the object
if(!xmlhttp && typeof XMLHttpRequest != 'undefined')
{
	xmlhttp = new XMLHttpRequest();
}

function performSearch(sstr,e)
{
  //alert('performSearch ' + sstr);
	loadServerContent('tabs-1',"searchData.php?searchText=" + sstr);
}
function loadServerContent(objID,pageID)
{
	
		//The page we are loading
		var serverPage=pageID;
	  //alert('serverPage ' + serverPage);
		var obj = document.getElementById(objID);
		xmlhttp.open("GET",serverPage);
	
		xmlhttp.onreadystatechange = function() 
					{
						if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
						{
							obj.innerHTML = xmlhttp.responseText;
			
						}
						
					}
		
		
		xmlhttp.send(null);
	

}
/*
$(document).ready(function(){  
$("#searchTB").onkeypress(function(){  
	$("#searchResults").load("sQuerySongs.php?A");  
	});  
});  */


function render_json(results,decode)
{
	var str="";
	alert(results);
	if(decode == 1)
	{
		$.each(results,function(i,doc)
			{
				str = str + doc.doc_name + " " +
					        doc.doc_type + " " +
				    	    doc.doc_text;
			});
	}
	else
	{
		str = results;
	}
	document.getElementById("searchResults").innerHTML = str;
}

function render_data()
{
     $.getJSON("searchData.php?searchText="+$("#searchText").val(),
            		function(json) {		
            						var str = "";
                                    $.each(json,function(key,doc){ 
                                    		 str = str +  '<div class="resultItem">' + "<b>" +  doc.doc_name + "</b>" +
                                    		              "<pre>" +  hiliteKeywords(doc.doc_text) + "</pre>" +
                                    		              "</div><BR>";
                                    		              });
									document.getElementById("searchResults").innerHTML = str;		
									$("#searchResults").css('display','block');
								});
}

function hiliteKeywords(str)
{

	var keywords = new Array("JOB ","EXEC "," PROC ","DISP","NEW","CATLG","DELETE","DD","DSN","PGM","SHR","MOD","MSGCLASS","CLASS",
	                         "NOTIFY","LRECL","BLKSIZE","DSORG");

	for(i=0;i<keywords.length;i++)
	{
		var regex = new RegExp(keywords[i],"gi");
		str = str.replace(regex,'<span id="keyword">' + keywords[i] + '</span>');
	}
	return str;
}