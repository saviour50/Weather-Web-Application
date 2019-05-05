<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="main.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Weather App</title>
</head>
<body>

<div class="location">
	<h2 class="location-timezone"> TimeZone </h2>
	<canvas class="icon" width="128" height="128"></canvas>
</div>

<div class="temperature">
	<div class="degree">
		<h2 class="temperature-degree">50</h2>
	<span> F</span>
	</div>
	<div class="temperature-description"> Its really cold
	</div>
</div>


<script src="skycons.js"></script>
<script type="text/javascript">
	
window.addEventListener('load',()=>{

let long;
let lat;
let temperatureDegree = document.querySelector(".temperature-degree");
let temperatureDescription = document.querySelector(".temperature-description");

let locationTimezone = document.querySelector(".location-timezone");
let temperatureSection = document.querySelector(".temperature");
let temperatureSpan = document.querySelector(".temperature span");
if(navigator.geolocation){
	navigator.geolocation.getCurrentPosition(position=>{
	
	long = position.coords.longitude;
	lat = position.coords.latitude;

	const proxy =  'http://cors-anywhere.herokuapp.com/';

	const api = `${proxy}https://api.darksky.net/forecast/abeb59b533d3e0603c660f44dddd10e1/${lat},${long}`;

	
	
	fetch(api)
	.then(response =>{
		return response.json();
	})
	.then(response =>{
		console.log(response)

	const{temperature, summary, icon} = response.currently;

	//Set Dom Element from the API
	temperatureDegree.textContent = temperature;
	temperatureDescription.textContent = summary;
	locationTimezone.textContent = response.timezone;

	let celsius = (temperature -32) *(5/9);


	//set icon
	setIcons(icon, document.querySelector('.icon'));

	temperatureSection.addEventListener('click',()=>{
		if(temperatureSpan.textContent === 'F'){
			temperatureSpan.textContent = 'C';
			temperatureDegree.textContent = Math.floor(celsius) ;
		}else {
			temperatureSpan.textContent = 'F'
			temperatureDegree.textContent = temperature;
		}
	})

	});

});

	
} 

function setIcons(icon, iconID){

	const skycons = new Skycons({color: "white"});
	const currentIcon = icon.replace(/-/g, "_").toUpperCase();

	skycons.play();

return skycons.set(iconID, Skycons[currentIcon]);



}
});


</script>

</body>
</html>