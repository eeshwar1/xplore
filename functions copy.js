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
	//loadServerContent('searchResults',"searchData.php?searchText=" + sstr);
	
	$("#searchResults").load("searchData.php?searchText=" + sstr);
}
function loadServerContent(objID,pageID)
{
	
		//The page we are loading
		var serverPage=pageID;
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
