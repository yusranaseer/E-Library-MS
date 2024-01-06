const hamburger = document.querySelector('.header .nav-bar .nav-list .hamburger');
const mobile = document.querySelector('.header .nav-bar .nav-list ul');
const menu = document.querySelectorAll('.header .nav-bar .nav-list ul li a');
const header = document.querySelector('.header.container');

hamburger.addEventListener('click', () => {
	hamburger.classList.toggle('active');
	mobile.classList.toggle('active');
});

menu.forEach((item)=>{
	item.addEventListener('click',()=>{
		hamburger.classList.toggle('active');
		mobile.classList.toggle('active');
	});
});

document.addEventListener('scroll',()=>{
	 
	if (window.scrollY > 150)
	{
		header.style.backgroundColor = 'black';
	}
	else
	{
		header.style.backgroundColor = 'transparent';
	}
});

