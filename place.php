<?php

  if(isset($_GET['p1']) && isset($_GET['p2']))
  {

   $APIkey="AIzaSyDptlHYXtPhfVcziZpdoNTrs1Iq0ALEDYo";
   $w=$_GET['p1'];
   $h=$_GET['p2'];
   $radius=$_GET['radius'];
   $type=$_GET['type'];
   $keyword=$_GET['keyword'];
   $url1= "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$w.",".$h."&radius=".$radius."&type=".$type."&keyword=".urlencode($keyword)."&key=".$APIkey;
   $jsonobj=file_get_contents($url1);
   echo $jsonobj;
   die();
  }

  else if(isset($_GET['address']))
  {
   $APIkey="AIzaSyDptlHYXtPhfVcziZpdoNTrs1Iq0ALEDYo";
   $location=$_GET['address'];
   $radius=$_GET['radius'];
   $type=$_GET['type'];
   $keyword=$_GET['keyword'];
   $url2 ="https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($location)."&key=".$APIkey;
   $jsonobj1=file_get_contents($url2);
   $jsonDec = json_decode($jsonobj1,true);
   $loc=[];
   $location=$jsonDec['results'];
   if(isset($location[0]))
   {
   array_push($loc,$location[0]['geometry']['location']);
   $url3= "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$loc[0]['lat'].",".$loc[0]['lng']."&radius=".$radius."&type=".$type."&keyword=".urlencode($keyword)."&key=".$APIkey;
   $jsonobj2=file_get_contents($url3);
   echo $jsonobj2;
   }
   else
   {
    $nf["nolat"]="no";
    echo json_encode($nf);
   }
   die();
  }

   else if(isset($_GET['placeid']))
   {
    
    $APIkey="AIzaSyDptlHYXtPhfVcziZpdoNTrs1Iq0ALEDYo";
    $placeid=$_GET['placeid'];
    $url4="https://maps.googleapis.com/maps/api/place/details/json?placeid=".$placeid."&key=".$APIkey;
    $jsonobj4=file_get_contents($url4);
    echo $jsonobj4;
    $photo=json_decode($jsonobj4,true);
    if(isset($photo['result']['photos']))
    {
    $photoref=$photo['result']['photos'];
    if (sizeof($photoref)<5 && sizeof($photoref)!=0)
    {
       for ($i=0; $i<sizeof($photoref); $i++)
      {
        $pic="photo";
        $extenstion=".jpeg";
        $url5="https://maps.googleapis.com/maps/api/place/photo?maxwidth=750&photoreference=".$photoref[$i]['photo_reference']."&key=".$APIkey;
        $photocontents1=file_get_contents($url5);
        $resultFile=$pic.$i;
        file_put_contents($resultFile.$extenstion,$photocontents1);
      }
    }
    else if(sizeof($photoref)>=5)
    {
      for ($i=0; $i<5; $i++)
      {
        $pic="photo";
        $extenstion=".jpeg";
        $url5="https://maps.googleapis.com/maps/api/place/photo?maxwidth=750&photoreference=".$photoref[$i]['photo_reference']."&key=".$APIkey;
        $photocontents1=file_get_contents($url5);
        $resultFile=$pic.$i;
        file_put_contents($resultFile.$extenstion,$photocontents1);
      }
    }
   }
    die();
   }

?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<head>
  <title>Travel and Entertainment Search</title>
  <script type="text/javascript">
  function myFunctionEnable() {
      document.getElementById("location").disabled = false;
  }
  function myFunctionDisable()
  {
    document.getElementById("location").disabled=true;
  }

     function getGeoLoc()
          {
              var xmlhttp=new XMLHttpRequest(); 
              xmlhttp.onreadystatechange = function()
              { 
                
               if (this.status == 200 && this.readyState == 4)
                {
                    var response = JSON.parse(this.responseText);
                    getGeoLoc.responseLat=response.lat;
                    getGeoLoc.responseLon=response.lon;

                }
              }
             xmlhttp.open("GET","http://ip-api.com/json",true);
             xmlhttp.timeout=1000;
             xmlhttp.ontimeout=function(e)
             {
              
               getGeoLoc.responseLat= 34.022352;
               getGeoLoc.responseLon= -118.285117;
             }
            xmlhttp.send();
            button.disabled=false;     
          }
      getGeoLoc.responseLat="";
      getGeoLoc.responseLon="";

  </script>
  <style type="text/css">
    #formid
    {
     
     background-color: #f9f9f9;
     width:700px;
     margin:0 auto;
     border: 2px solid dimgray;
    }
    
    hr
    {
      background-color:dimgray;
      opacity:1;
    }
    #map
    {
      height:250px;
      width:350px;
      z-index:1;
      position: absolute;
    }

    #transport
    {
        background: #f7f2f2;
        display: block;
        width: 100px !important;
        height: 95px !important;
    }
    #tableID
    {
      margin:0 auto;
    }
    #photos
    {
      margin-left:auto;
      margin-right:auto;
      display:block;
    }
    #transport
    {
      position: absolute;
      z-index:3;
      height:50px;
      width:30px;
    }
    
    .imageClass
    {
        width:35px;
        display: block;
        margin: 0 auto;
    }
    .hyperLink 
    {
      text-decoration: none;
      color:black;
    }

    .mapHyperlink 
    {
      text-decoration: none;
      color:black;
      padding:7px 7px;
      display:block;
    }
    .mapHyperlink:hover
    {
       background-color:#e0dbdb;
    }

    .grayHyperlink
    {
      text-decoration: none;
      color:black;
    }

    .grayHyperlink:active
    {
       color:#e0dbdb;
    }

    .borderClass {
    border: 1px solid black;
    border-collapse: collapse;
    }
    .paddingClass
    {
      padding-top: 20px;
      padding-bottom: 20px;
    }
    
    #locationRadio
    {
      margin-left:24.9em;
    }
    
  </style>
</head>
<body onload ="getGeoLoc();">
  <div id="formid">
      <form id="form" action="JavaScript:ajaxRequest()">
        </br>
        <h1 style="text-align: center;margin:0px"><b><i>Travel and Entertainment Search</i></b></h1>
        <hr>
        <p>
          <label><b>&nbsp;Keyword</b></label>
          <input type = "text"
                id="keyword" required>
        </p>
        <p>
          <label><b>&nbsp;Category</b></label>
          <select id="type">
          <option value="default" id="default">default</option>
          <option value="cafe">cafe</option>
          <option value="bakery">bakery</option>
          <option value="restaurant">restaurant</option>
          <option value="beauty_salon">beauty salon</option>
          <option value="casino">casino</option>
          <option value="movie_theater">movie theater</option>
          <option value="lodging">lodging</option>
          <option value="airport">airport</option>
          <option value="train_station">train station</option>
          <option value="subway_station">subway station</option>
          <option value="bus_station">bus station</option>
      </select> 
        </p>

        <p>
          <label><b>&nbsp;Distance (miles)</b></label>
          <input type = "text" id="radius" placeholder="10" />
          <label><b>from</b></label>
          <input onclick="myFunctionDisable()" type="radio" name="loc" id="here" value="here" checked/> Here <br>
          <input onclick="myFunctionEnable()" type="radio" name="loc" id="locationRadio" value="locationRadio">
          <input type="text" id="location" placeholder="location" name="location" disabled required>
          ​​​​​​​​​​​​​​​​​​​​​​​​​​​​</p>
          &emsp;&emsp;&emsp;&emsp;<input id="submit" type="submit" name="submit" value="Search"/>
          <script>
          var button = document.getElementById("submit");
          button.disabled = true;
       
          </script>
          <input type="button" value="Clear" onclick="clearAll()">
          <br>
          <br>
      
    </form>
  </div>
   <br><br>
  <div id="tableID">
  </div>
  <div id="reviewBlock">
  </div>
  <div id="review">
  </div>
  <div id="photoBlock">
  </div>
  <div id="photos">
  </div>
 

  <script>
    function clearAll()
    {
      document.getElementById("keyword").value="";
      document.getElementById("type").value="default";
      document.getElementById("radius").placeholder=10;
      document.getElementById("radius").value="";
      document.getElementById("here").checked=true;
      document.getElementById("location").disabled=true;
      document.getElementById("location").placeholder="location";
      document.getElementById("location").value="";

      document.getElementById("tableID").innerHTML="";
      document.getElementById("reviewBlock").innerHTML = "";
      document.getElementById("photoBlock").innerHTML = "";
      document.getElementById("photos").innerHTML = "";
      document.getElementById("review").innerHTML = "";
   }

    function ajaxRequest()
    {
      if(document.getElementById("radius").value=="")
      {
        document.getElementById("radius").value='10';
      }
      a =document.getElementById("radius").value * 1609.34;
      url="place.php?p1="+getGeoLoc.responseLat+"&p2="+getGeoLoc.responseLon+"&radius="+a+"&keyword="+document.getElementById("keyword").value+"&type="+document.getElementById("type").value;
      url2="place.php?address="+document.getElementById("location").value+"&radius="+a+"&keyword="+document.getElementById("keyword").value+"&type="+document.getElementById("type").value;
      var xhr= new XMLHttpRequest();
      xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) 
      {
        
        //console.log(this.responseText);
        var jsonResponse=JSON.parse(this.responseText);
        var body = document.getElementById("tableID");
        var tbl = document.createElement("table");
        var tblBody = document.createElement("tbody");
        var result=jsonResponse.results;
        if((jsonResponse.status != "OK") || (jsonResponse.nolat == "no"))
        {
          var row1 = document.createElement("tr");    
          var cell = document.createElement("th");
          cell.setAttribute("class", "borderClass"); 
          var cellText = document.createTextNode("No Records has been found");
          cell.appendChild(cellText);
          row1.appendChild(cell); 
          tblBody.appendChild(row1); 
        }
        else
        {
        var heading= document.createElement("tr");
        var head=document.createElement("th");
        head.setAttribute("class","borderClass");
        var headName = document.createTextNode("Category");
        head.appendChild(headName);
        heading.appendChild(head);
        var head1=document.createElement("th");
        head1.setAttribute("class","borderClass");
        var headName1 = document.createTextNode("Name");
        head1.appendChild(headName1);
        heading.appendChild(head1);
        var head2=document.createElement("th");
        head2.setAttribute("class","borderClass");
        var headName2 = document.createTextNode("Address");
        head2.appendChild(headName2);
        heading.appendChild(head2);
        tblBody.appendChild(heading);
        for(i=0;i<result.length;i++) 
        {                 
                nodeList=result[i];
                 
                 var row = document.createElement("tr");     
                  var keys = Object.keys(nodeList);
                  for(j=0;j<keys.length;j++) 
                  {
                         prop = keys[j];

                       if(keys[j]=="icon")    
                       {      
                         var cell = document.createElement("td");
                         cell.setAttribute("class","borderClass");
                         var cellImage = document.createElement("img");
                         cellImage.src =nodeList[prop];
                         cellImage.setAttribute("height",45);
                         cellImage.setAttribute("width",65);
                         cell.appendChild(cellImage);
                         row.appendChild(cell);     
                        }  


                       else if(keys[j]=="name")    
                       {      
                         var cell = document.createElement("td");
                         cell.setAttribute("class","borderClass");
                         var cellName = document.createElement("a");
                         cellName.setAttribute("class","hyperLink");
                         var linkText = document.createTextNode(nodeList[prop]);
                         cellName.appendChild(linkText);
                         cellName.href="";
                              
                          cellName.addEventListener('click', (function(event){ 
                            var obj=nodeList;
                            return function(event) {
                            event.preventDefault();
                            reviewFunc(obj);
                          }
                        })());
                         
                         cell.appendChild(cellName);
                         row.appendChild(cell);
                       }    
                        else if(keys[j]=="vicinity")    
                       { 

                         var cell = document.createElement("td");
                         cell.setAttribute("class","borderClass");
                         var cellText = document.createElement("a");
                         
                         cellText.setAttribute("class","grayHyperlink");
                         var linkText = document.createTextNode(nodeList[prop]);
                         cellText.appendChild(linkText);
                         cellText.href="#";
                         cellText.addEventListener('click', (function(event){ 
                          var cellCurrent= cell;
                          var obj1=nodeList;
                           return function(event) {
                            event.preventDefault();
                            if(document.getElementById("map"))
                            {
                              var transport=document.getElementById("transport");
                              var map=document.getElementById("map");
                              cellCurrent.removeChild(transport);
                              cellCurrent.removeChild(map);
                            }
                            else
                            {
                              var mapdiv=document.createElement("div");
                              mapdiv.setAttribute("id","map");
                              var transportdiv=document.createElement("div");
                              transportdiv.setAttribute("id","transport");
                              cellCurrent.appendChild(transportdiv);
                              cellCurrent.appendChild(mapdiv);
                              callMap(obj1);
                            }
                          }
                        })());
                     
                         cell.appendChild(cellText);
                         row.appendChild(cell);     
                        }              
                  }

      
          tblBody.appendChild(row);
          tableID.style.display="block";
        }
      }
 
         tbl.appendChild(tblBody);
         body.appendChild(tbl);
         tbl.setAttribute("class", "borderClass"); 
         tbl.setAttribute("align","center") 
         tbl.setAttribute("width",1000)                    
      }
    }
      
      if(document.getElementById("location").value=="")
      { 
        xhr.open("GET",url, true);
      }
      else
      {
        xhr.open("GET",url2,true);
      }
      xhr.send();
}


function reviewFunc(obj)
{
      url4="place.php?placeid="+obj.place_id;
      var xhr= new XMLHttpRequest();
   
      var div = document.getElementById("tableID");
      div.style.display = "none";


      var showReview =document.getElementById("reviewBlock");
      showReview.innerHTML="<br><center><b>"+obj.name+"</b></center><br>";
      var text =document.createElement("p");
      var t = document.createTextNode("Click to show reviews");
      text.setAttribute("align","center");      
      text.appendChild(t);
      text.setAttribute("id","textID");
      showReview.appendChild(text);

      var cellImage = document.createElement("img");
      cellImage.setAttribute("id","imageID")
      cellImage.src = "http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png";
      cellImage.setAttribute("class","imageClass")
      cellImage.setAttribute("onclick", "changeReview();");
      showReview.appendChild(cellImage);

      var photoReview =document.getElementById("photoBlock");
      var text1 =document.createElement("p");
      var t1 = document.createTextNode("Click to show photos");
      text1.setAttribute("align","center");      
      text1.appendChild(t1);
      text1.setAttribute("id","textID1"); 
      photoReview.appendChild(text1);

      var cellImage1 = document.createElement("img");
      cellImage1.setAttribute("id","imageID2")
      cellImage1.src = "http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png";
      cellImage1.setAttribute("class","imageClass")
      cellImage1.setAttribute("onclick", "changeImage();");
      photoReview.appendChild(cellImage1);
       
     
      xhr.onreadystatechange = function()
      {
      if (this.readyState == 4 && this.status == 200) 
      {
   
       // console.log(this.responseText);

        var jsonResponse=JSON.parse(this.responseText);
        var body = document.getElementById("review");
        var tbl = document.createElement("table");
        var tblBody = document.createElement("tbody");
        var result=jsonResponse.result.reviews;
        if(typeof(jsonResponse.result.reviews) == "undefined")
        {
                          var row1 = document.createElement("tr");    
                          var cell = document.createElement("th");
                          cell.setAttribute("class", "borderClass"); 
                          var cellText = document.createTextNode("No Reviews Found");
                          cell.appendChild(cellText);
                          row1.appendChild(cell); 
                          tblBody.appendChild(row1); 
        }
        else
        {
          if(result.length>5)
          {
               for(i=0;i<result.length;i++) 
               {                 
                  nodeList=result[i];
                  var row = document.createElement("tr");
                  var cell = document.createElement("th");
                  cell.setAttribute("class", "borderClass");
                  var cellImage = document.createElement("img");
                  cellImage.src =nodeList.profile_photo_url;
                  cellImage.setAttribute("width",30);
                  cellImage.setAttribute("height",30);
                  cell.appendChild(cellImage); 
                  var cellText = document.createTextNode(nodeList.author_name);
                  cell.appendChild(cellText);
                  row.appendChild(cell);
                  tblBody.appendChild(row); 
                  var row1 = document.createElement("tr");    
                  var cell = document.createElement("td");
                  cell.setAttribute("class", "borderClass"); 
                  var cellText = document.createTextNode(nodeList.text);
                  cell.appendChild(cellText);
                  row1.appendChild(cell); 
                  tblBody.appendChild(row1);     
                }
            }
        
        else
        {

            for(i=0;i<result.length;i++) 
              {      
                  nodeList=result[i];
                  var row = document.createElement("tr");
                  var cell = document.createElement("th");
                  cell.setAttribute("class", "borderClass");
                  var cellImage = document.createElement("img");
                  cellImage.src =nodeList.profile_photo_url;
                  cellImage.setAttribute("width",30);
                  cellImage.setAttribute("height",30);
                  cell.appendChild(cellImage); 
                  var cellText = document.createTextNode(nodeList.author_name);
                  cell.appendChild(cellText);
                  row.appendChild(cell);
                  tblBody.appendChild(row); 
                  var row1 = document.createElement("tr");    
                  var cell = document.createElement("td");
                  cell.setAttribute("class", "borderClass"); 
                  var cellText = document.createTextNode(nodeList.text);
                  cell.appendChild(cellText);
                  row1.appendChild(cell); 
                  tblBody.appendChild(row1);    
               }
            }
        }

         tbl.appendChild(tblBody);
         body.appendChild(tbl);
         tbl.setAttribute("class", "borderClass"); 
         tbl.setAttribute("align","center")  
         tbl.setAttribute("width",800)                   
    

            var photo= document.getElementById("photos");
            var tbl1 = document.createElement("table");
            var tblBody1 = document.createElement("tbody");
            if(typeof(jsonResponse.result.photos) == "undefined")
            {
                          var row1 = document.createElement("tr");    
                          var cell = document.createElement("th");
                          cell.setAttribute("class", "borderClass"); 
                          var cellText = document.createTextNode("No Photos Found");
                          cell.appendChild(cellText);
                          row1.appendChild(cell); 
                          tblBody1.appendChild(row1); 
            }
            else
            {
              if(jsonResponse.result.photos.length>5)
              {
                for(i=0;i<5;i++)
                 {
                  var file="photo"+i+".jpeg";
                  var row = document.createElement("tr");
                  var cell = document.createElement("td");
                  var cellImage = document.createElement("img");
                  cellImage.src =file+"?"+obj.place_id;
                  cellImage.addEventListener('click', (function(){ 
                               var fileName=file;
                               return function(){
                                window.open(fileName);
                              }
                  })());
                  cell.setAttribute("align","center");
                  cell.setAttribute("class","borderClass");
                  cellImage.setAttribute("class","paddingClass");
                  cell.appendChild(cellImage);
                  row.appendChild(cell);
                  tblBody1.appendChild(row);
                }
            }
            else
            {
                for(i=0;i<jsonResponse.result.photos.length;i++)
                 {
                  var file="photo"+i+".jpeg";
                  var row = document.createElement("tr");
                  var cell = document.createElement("td");
                  var cellImage = document.createElement("img");
                  cellImage.src =file+"?"+obj.place_id;
                  cellImage.addEventListener('click', (function(){ 
                               var fileName=file;
                               return function(){
                                window.open(fileName);
                              }
                  })());
                  cell.setAttribute("align","center");
                  cell.setAttribute("class","borderClass");
                  cellImage.setAttribute("class","paddingClass");
                  cell.appendChild(cellImage);
                  row.appendChild(cell);
                  tblBody1.appendChild(row);
                }
            }
        }
      
             tbl1.appendChild(tblBody1);
             photo.appendChild(tbl1);
             tbl1.setAttribute("class", "borderClass");
             tbl1.setAttribute("width",800)
             tbl1.setAttribute("align","center")

          }
        }
    
            
          xhr.open("GET",url4, true);
        xhr.send();
        review.style.display="none";
        photos.style.display="none";
}

function changeReview()
{
    photos.style.display="none";
    if(review.style.display==="none")
    {
       review.style.display="block";
    }
    if( document.getElementById("imageID2").src=="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png")
    {
        document.getElementById("textID1").innerHTML="Click to show photos";
         document.getElementById("imageID2").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png"
    }


    if( document.getElementById("imageID").src!="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png")
    {
         document.getElementById("textID").innerHTML="Click to hide reviews";
         document.getElementById("imageID").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png"
    }
    else
    {
      document.getElementById("textID").innerHTML="Click to show reviews";
      document.getElementById("imageID").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png"
      review.style.display="none";
    }
}

function changeImage()
{
  review.style.display="none";
  if(photos.style.display==="none")
  {
    photos.style.display="block";
  }

  if( document.getElementById("imageID").src=="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png")
    {
        document.getElementById("textID").innerHTML="Click to show reviews";
         document.getElementById("imageID").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png"
       
    }


  if( document.getElementById("imageID2").src!="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png")
    {
         document.getElementById("textID1").innerHTML="Click to hide photos";
         document.getElementById("imageID2").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png"
      
    }
    else
    {
      document.getElementById("textID1").innerHTML="Click to show photos";
      document.getElementById("imageID2").src="http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png"
      photos.style.display="none";
    }
  
  
}


function callMap(obj1)
{

    var lats=obj1.geometry.location.lat;
    var lngs= obj1.geometry.location.lng;

    var transport=document.getElementById("transport");


    var cellName = document.createElement("a");
    cellName.setAttribute("class","mapHyperlink");
    cellName.setAttribute("id","walk");
    var linkText = document.createTextNode("Walk There");
    cellName.appendChild(linkText);
    cellName.href="#";
    var br = document.createElement("br");
    cellName.appendChild(br);
    transport.appendChild(cellName);

    var cellName1 = document.createElement("a");
    cellName1.setAttribute("class","mapHyperlink");
    cellName1.setAttribute("id","bike");
    var linkText1 = document.createTextNode("Bike There");
    cellName1.appendChild(linkText1);
    cellName1.href="#";
    var br1 = document.createElement("br");
    cellName1.appendChild(br1);
    transport.appendChild(cellName1);
   
    
    var cellName2 = document.createElement("a");
    cellName2.setAttribute("class","mapHyperlink");
    cellName2.setAttribute("id","drive");
    var linkText2 = document.createTextNode("Drive There");
    cellName2.appendChild(linkText2);
    cellName2.href="#";
    transport.appendChild(cellName2);
    
    initMap(lats,lngs);

}

function initMap(lats,lngs)
{
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;
  var uluru = {lat: lats, lng: lngs};
  var map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: uluru
  });
  var marker = new google.maps.Marker({
    position: uluru,
    map: map
  });
directionsDisplay.setMap(map);




var walk=document.getElementById("walk");
if(walk)
{
walk.addEventListener('click', (function(event){ 
                        return function(event)
                            {
                              event.preventDefault();
                              marker.setMap(null);
                              calculateAndDisplayRoute(directionsService, directionsDisplay,uluru,"WALKING");
                            }
                          })());
}

var bike=document.getElementById("bike");
if(bike)
{
bike.addEventListener('click', (function(event){ 
                          return function(event)
                            {
                              event.preventDefault();
                              marker.setMap(null);
                              calculateAndDisplayRoute(directionsService, directionsDisplay,uluru,"BICYCLING");
                            }
                          })());
}


var drive=document.getElementById("drive");
if(drive)
{
drive.addEventListener('click', (function(event){ 
                          return function(event)
                            {
                              event.preventDefault();
                               marker.setMap(null);
                              calculateAndDisplayRoute(directionsService, directionsDisplay,uluru,"DRIVING");
                            }
                          })());

}

}

  

function calculateAndDisplayRoute(directionsService, directionsDisplay,uluru,mode) {
 
 var mode=mode;
 
 if(document.getElementById("location").value!="")
  {
    var place =document.getElementById("location").value;
  }
  else
    place={lat:getGeoLoc.responseLat, lng:getGeoLoc.responseLon};
 

  directionsService.route({
    origin: place,  
    destination:uluru,   
    travelMode: google.maps.TravelMode[mode]
  }, function(response, status) {
    if (status == 'OK') {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
 }


</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDptlHYXtPhfVcziZpdoNTrs1Iq0ALEDYo">
</script>



</body>
</html>