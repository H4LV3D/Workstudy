// let but = document.querySelector(".bite").disabled = true;
// console.log(but);

let placement = "SEALD";     //this is just hardcoded for now 

document.querySelector(".btn").disabled = true ;  

const posArr = [];

const placemaps = [
    {place : "mech" , lat : 6.673222, long : 3.162683}, 
    {place : "csis" , lat : 6.671592, long : 3.152}, 
    {place : "chapel" , lat :6.658888 , long : 3.176285},
    {place : "residency" ,lat :6.658888 , long : 3.176285 },
    {place : "library" , lat :6.658888 , long : 3.176285},
    {place : "chaplaincy" , lat :6.658888 , long : 3.176285} ,
    {place : "LT" , lat :6.674619994440304, long : 3.158514561864209},
    {place: "SEALD", lat : 6.6695116, long : 3.1581207 } 
];
document.write(`${placemaps[7].lat}, ${placemaps[7].long}`)

window.onload = function() {
  var startPos;
  var geoSuccess = function(position) {
    startPos = position;
    document.getElementById('startLat').innerHTML = startPos.coords.latitude;
    let lat = startPos.coords.latitude;
    document.getElementById('startLon').innerHTML = startPos.coords.longitude;
    let long = startPos.coords.longitude;
    console.log(`${lat} , ${long}`);
    compare(lat, long)
  };
  navigator.geolocation.getCurrentPosition(geoSuccess);
};


function compare (lat , long){
          let i = placemaps.findIndex(x => x.place === placement);
      if (placement == placemaps[i].place ){
        if( ((placemaps[i].lat - 0.0002) <= lat && lat <= (placemaps[i].lat + 0.0002) ) && ((placemaps[i].long - 0.0002) <= long && long <= (placemaps[i].long + 0.0002))){
        document.querySelector(".btn").disabled = false;
        alert("You can now sign in");
        but.disabled = false;
      } 
    }else{
        alert("You need to get to your work place");
      };
    };


  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  let searchBtn = document.querySelector(".bx-search");

  closeBtn.addEventListener("click", ()=>{
      sidebar.classList.toggle("open");
      menuBtnChange();//calling the function(optional)
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search icon
      sidebar.classList.toggle("open");
      menuBtnChange(); //calling the function(optional)
  });

  // following are the code to change sidebar button(optional)
  function menuBtnChange() {
  if(sidebar.classList.contains("open")){
      closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the icons class
  }else {
      closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the icons class
  }
  }

  document.addEventListener('DOMContentLoaded', function () {
  var btn = document.querySelector('.bite'),
  loader = document.querySelector('.loader'),
  check = document.querySelector('.check');

  btn.addEventListener('click', function () {
      loader.classList.add('active');    
  });
  
  loader.addEventListener('animationend', function() {
      check.classList.add('active'); 
  });
  });


  
