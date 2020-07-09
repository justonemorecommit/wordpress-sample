const imageWidth = 300;
const imageHeight = 300;

const allVideos = [
	'<div class="max-w-3xl m-auto"><div style="position: relative; padding-bottom: 75%; height: 0;"><iframe src="https://www.loom.com/embed/d161338359e441839fb420e0eac3c706" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe></div></div>',
	'<div class="max-w-3xl m-auto"><div style="position: relative; padding-bottom: 56.25%; height: 0;"><iframe src="https://www.loom.com/embed/246498616c564845b8d85ddcfcc75147" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe></div></div>',
	'<div class="max-w-md m-auto"><div style="position: relative; padding-bottom: 158.33333333333334%; height: 0;"><iframe src="https://www.loom.com/embed/45fc9d52adca4791b2979c10d7958a6d" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></iframe></div></div>'
]

const allImages = [
	//'assets/adrian.png',
	'assets/anke.png',
	'assets/anton.png',
	'assets/burak.png',
	'assets/chaima.png',
	'assets/christian.png',
	//'assets/christoph.png',
	'assets/dagmar.png',
	'assets/daniel.png',
	'assets/fabio.png',
	'assets/hanna.png',
	'assets/hannaf.png',
	'assets/jan.png',
	'assets/janine.png',
	'assets/jens.png',
	'assets/jethro.png',
	//'assets/jonas.png',
	'assets/jonasg.png',
	'assets/karla.png',
	'assets/karo.png',
	'assets/lena.png',
	'assets/lukas.png',
	'assets/lukasw.png',
	'assets/marcel.png',
	'assets/markus.png',
	'assets/marlene.png',
	'assets/max.png',
	'assets/michael.png',
	'assets/milena.png',
	'assets/moritz.png',
	'assets/muecahid.png',
	'assets/nazar.png',
	'assets/petro.png',
	'assets/phillip.png',
	'assets/sam.png',
	'assets/stephan.png',
	'assets/steven.png',
	'assets/subodh.png',
	'assets/tim.png',
	'assets/tinka.png',
	'assets/tobi.png',
	'assets/vasyl.png',
	'assets/verena.png',
	'assets/victor.png',
	'assets/vsevolod.png',
	'assets/yanick.png',
	'assets/yurii.png',
]


addVideos(allVideos)
addParts(allImages)

function addVideos(videos){
	shuffle(videos);

	$('#video1').html(videos[0]);
	$('#video2').html(videos[1]);
	$('#video3').html(videos[2]);
}

function addParts(images){
	shuffle(images);
	images.push('assets/other.png');

	addTheFollowingImages('#parts1', images.slice(0, 3) );
	addTheFollowingImages('#parts2', images.slice(3, 9) );
	addTheFollowingImages('#parts3', images.slice(9, 18) );
	addTheFollowingImages('#parts4', images.slice(18) );
}

function addTheFollowingImages(domElement, images){
	for(let i in images){
		const img = images[i];
		const rollTheDice = Math.round(Math.random()*5 + 1);
		if (rollTheDice === 1 || rollTheDice === 2) {
			generateSheetDom(domElement, imageWidth, imageHeight, img, generateSheetProperties());	
		}else if (rollTheDice === 3 || rollTheDice === 4){
			generateTubeDom(domElement, imageWidth, imageHeight, img, generateTubeProperties());
		}else{
			generateTurningDom(domElement, imageWidth, imageHeight, img, generateTurningProperties());
		}
	}
}

function generateSheetProperties(){
	let props = {
		base: {},
		t1: {},
		t2: {},
		t3: {},
		b1: {},
		b2: {},
		b3: {},
		r1: {},
		r2: {},
		l1: {},
		l2: {},
		tl: {},
		tr: {},
		bl: {},
		br: {},
		rotation: {},
		delay: false
	}

	// —————————————————————————————————
	// Generate flexible sizes
	// —————————————————————————————————
	// Base
	props.base.w = 0.2 + Math.random() * 0.1;
	props.base.h = 0.2 + Math.random() * 0.2;
	// Top
	props.t1.h = 0.18 + Math.random() * 0.05;
	props.t3.h = 0.04 + Math.random() * 0.02;
	// Bottom
	props.b1.h = 0.18 + Math.random() * 0.05;
	props.b3.h = 0.04 + Math.random() * 0.02;
	// Camera
	props.rotation = {x: 30 + Math.random()*15, y: 0, z: Math.random()*180 - 90}
	props.delay = Math.random() * 10;

	// —————————————————————————————————
	// Derive
	// —————————————————————————————————
	props.r2.w = props.base.w / 2 * Math.random();
	props.l2.w = props.base.w / 2 * Math.random();

	props.t2.h = props.b2.h = (1 - props.base.h - props.t1.h - props.t3.h - props.b1.h - props.b3.h) / 2;
	props.l1.w = props.r1.w = (1 - props.base.w - props.l2.w - props.r2.w) / 2;

	// —————————————————————————————————
	// Copy static properties
	// —————————————————————————————————
	props.t1.w = props.t2.w = props.t3.w = props.base.w
	props.b1.w = props.b2.w = props.b3.w = props.base.w
	props.l1.h = props.l2.h = props.base.h
	props.r1.h = props.r2.h = props.base.h

	props.tl.h = props.tr.h = props.t1.h + props.t2.h + props.t3.h
	props.bl.h = props.br.h = props.b1.h + props.b2.h + props.b3.h

	props.tl.w = props.bl.w = props.l2.w + props.l1.w;
	props.tr.w = props.br.w = props.r2.w + props.r1.w;

	return props;
}

function shuffle(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
    return a;
}

function generateSheetDom (container, w, h, bg, p) {
	let randomID = Math.round(Math.random() * 10000);
	let animationName = 'tiltObject_' + randomID

	$('#animations').append('<style>@keyframes ' + animationName + ' { 0%, 10%  {transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);} 45%, 55%  {transform: rotateX(' + p.rotation.x + 'deg) rotateY(' + p.rotation.y + 'deg) rotateZ(' + p.rotation.z + 'deg);} 90%, 100% {transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);}}</style>')

	let style = {
		wrapper: 'width: ' + w + 'px; height: ' + h + 'px;',
		container: 'width: ' + w + 'px; height: ' + h + 'px; animation-name:' + animationName + ';',
		base: 'width: ' + p.base.w * w + 'px; height: ' + p.base.h * h + 'px; left:' + p.tl.w * w + 'px; top:' + p.tl.h * h + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position:' + (p.tl.w) * -w + 'px ' + (p.tl.h) * -h + 'px;',

		tl: 'width: ' + p.tl.w * w + 'px; height: ' + p.tl.h * h + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: 0px 0px;',
		tr: 'width: ' + p.tr.w * w + 'px; height: ' + p.tr.h * h + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: ' + (p.tl.w + p.base.w) * -w + 'px 0px;',

		bl: 'width: ' + p.bl.w * w + 'px; height: ' + p.bl.h * h + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: 0px ' + (p.tl.h + p.l2.h) * -h + 'px;',
		br: 'width: ' + p.br.w * w + 'px; height: ' + p.br.h * h + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: ' + (p.tl.w + p.base.w) * -w + 'px ' + (p.tl.h + p.l2.h) * -h + 'px;',

		t1: 'width: ' + p.t1.w * w + 'px; height: ' + p.t1.h * h + 'px; top: ' + (-p.t1.h * h) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position:' + p.tl.w * -w + 'px ' + (p.t2.h + p.t3.h) * -h + 'px;',
		t2: 'width: ' + p.t2.w * w + 'px; height: ' + p.t2.h * h + 'px; top: ' + (-p.t2.h * h) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position:' + p.tl.w * -w + 'px ' + (p.t3.h) * -h + 'px;',
		t3: 'width: ' + p.t3.w * w + 'px; height: ' + p.t3.h * h + 'px; top: ' + (-p.t3.h * h) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position:' + p.tl.w * -w + 'px 0px;',

		b1: 'width: ' + p.b1.w * w + 'px; height: ' + p.b1.h * h + 'px; bottom: ' + (-p.b1.h * h) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: ' + (p.tl.w) * -w + 'px ' + (p.t1.h + p.t2.h + p.t3.h + p.base.h) * -h + 'px;',
		b2: 'width: ' + p.b2.w * w + 'px; height: ' + p.b2.h * h + 'px; bottom: ' + (-p.b2.h * h) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: ' + (p.tl.w) * -w + 'px ' + (p.t1.h + p.t2.h + p.t3.h + p.base.h + p.b1.h) * -h + 'px;',
		b3: 'width: ' + p.b3.w * w + 'px; height: ' + p.b3.h * h + 'px; bottom: ' + (-p.b3.h * h) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: ' + (p.tl.w) * -w + 'px ' + (p.t1.h + p.t2.h + p.t3.h + p.base.h + p.b1.h + p.b2.h) * -h + 'px;',

		l1: 'width: ' + p.l1.w * w + 'px; height: ' + p.l1.h * h + 'px; left: ' + (-p.l1.w * w) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position:' + (p.l2.w) * -w + 'px ' + (p.tl.h) * -h + 'px;',
		l2: 'width: ' + p.l2.w * w + 'px; height: ' + p.l2.h * h + 'px; left: ' + (-p.l2.w * w) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: 0px ' + (p.tl.h) * -h + 'px;',

		r1: 'width: ' + p.r1.w * w + 'px; height: ' + p.r1.h * h + 'px; right: ' + (-p.r1.w * w) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: ' + (p.tl.w + p.base.w) * -w + 'px ' + (p.tr.h) * -h + 'px;',
		r2: 'width: ' + p.r2.w * w + 'px; height: ' + p.r2.h * h + 'px; right: ' + (-p.r2.w * w) + 'px; background-image: url(' + bg + '); background-size: ' + w + 'px; background-position: ' + (p.tl.w + p.base.w + p.r1.w) * -w + 'px ' + (p.tr.h) * -h + 'px;',
	}

	let dom = '';
	dom += '<div class="foldWrapper w-full sm:w-1/2 md:w-1/3 mb-24 inline-block">'
	dom += '	<div class="perspective" style="' + style.wrapper + '">'
	dom += '		<div class="container" style="' + style.container + '">'
	dom += '			<div class="p_tl" style="' + style.tl + '"></div>'
	dom += '			<div class="p_tr" style="' + style.tr + '"></div>'
	dom += '			<div class="p_base" style="' + style.base + '">'
	dom += '				<div class="p_t1" style="' + style.t1 + '">'
	dom += '					<div class="p_t2" style="' + style.t2 + '">'
	dom += '						<div class="p_t3" style="' + style.t3 + '"></div>'
	dom += '					</div>'
	dom += '				</div>'
	dom += '				<div class="p_b1" style="' + style.b1 + '">'
	dom += '					<div class="p_b2" style="' + style.b2 + '">'
	dom += '						<div class="p_b3" style="' + style.b3 + '"></div>'
	dom += '					</div>'
	dom += '				</div>'
	dom += '				<div class="p_l1" style="' + style.l1 + '">'
	dom += '					<div class="p_l2" style="' + style.l2 + '"></div>'
	dom += '				</div>'
	dom += '				<div class="p_r1" style="' + style.r1 + '">'
	dom += '					<div class="p_r2" style="' + style.r2 + '"></div>'
	dom += '				</div>'
	dom += '			</div>'
	dom += '			<div class="p_bl" style="' + style.bl + '"></div>'
	dom += '			<div class="p_br" style="' + style.br + '"></div>'
	dom += '		</div>'
	dom += '	</div>'
	dom += '</div>'

	let $elementToAppend = $(dom);
	$(container).append($elementToAppend);

	const elements = [
		[$elementToAppend.find('.container'), animationName],
		[$elementToAppend.find('.p_tl'), "fadeAndShift"],
		[$elementToAppend.find('.p_tr'), "fadeAndShift"],
		[$elementToAppend.find('.p_bl'), "fadeAndShift"],
		[$elementToAppend.find('.p_br'), "fadeAndShift"],
		[$elementToAppend.find('.p_t2'), "foldXInwards"],
		[$elementToAppend.find('.p_t3'), "foldXInwards"],
		[$elementToAppend.find('.p_b2'), "foldXOutwards"],
		[$elementToAppend.find('.p_b3'), "foldXOutwards"],
		[$elementToAppend.find('.p_l1'), "foldYInward"],
		[$elementToAppend.find('.p_l2'), "foldYInward"],
		[$elementToAppend.find('.p_r1'), "foldYOutward"],
		[$elementToAppend.find('.p_r2'), "foldYOutward"]
	]

	initAnimations(elements, p.delay)
}

function initAnimations(elements, delay){
	setAnimationForEach(elements, false);
	setTimeout(function(){
		setAnimationForEach(elements, true);

		setInterval(function(){
			setAnimationForEach(elements, false);
			setAnimationForEach(elements, true);
		}, 12000)
	}, delay * 1000);
}

function setAnimationForEach(elements, duration){
	for (let i in elements) {
		const element = elements[i][0];
		const animation = elements[i][1];
		if (duration === false) {
			element[0].style.animationName = 'none';
			// element[0].style.animationDuration = '0s';
			element.outerHeight();
		}else{
			element[0].style.animationName = animation;
			element.outerHeight();
		}
	}
}

function generateTubeProperties(){
	let props = {
		base: {},
		b: {},
		t: {},
		r1: {},
		l1: {},
		r2: {},
		l2: {},
		tr1: {},
		tr2: {},
		tr3: {},
		tl1: {},
		tl2: {},
		tl3: {},
		rotation: {},
		delay: false
	}

	// —————————————————————————————————
	// Generate flexible sizes
	// —————————————————————————————————
	props.rotation = {x: 45 + Math.random()*15, y: 0, z: Math.random()*180 - 90}
	props.delay = Math.random() * 10;

	props.base.w = 0.2 + Math.random() * 0.1;
	props.base.h = 0.6 + Math.random() * 0.2;

	props.tr1.h = props.tr2.h = props.tr3.h = props.tl1.h = props.tl2.h = props.tl3.h = props.base.h * Math.random() * 0.2;

	props.r1.h = props.r2.h = props.l1.h = props.l2.h = props.base.h - props.tr1.h;

	props.r2.w = props.l2.w = props.base.w/2;
	props.t.h = props.b.h = (1 - props.base.h) / 2;
	props.t.w = props.b.w = 1;

	props.l1.w = props.r1.w = (1 - props.base.w - props.l2.w - props.r2.w) / 2;

	// ———————

	props.tl1.w = props.tl2.w = props.l1.w;
	props.tr1.w = props.tr2.w = props.r1.w;

	props.tl3.w = props.l2.w;
	props.tr3.w = props.r2.w;

	return props;
}

function generateTubeDom (container, w, h, bg, p) {
	let randomID = Math.round(Math.random() * 10000);
	let animationName = 'tiltObject_' + randomID

	$('#animations').append('<style>@keyframes ' + animationName + ' { 0%, 10%   {transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);} 45%, 55%  {transform: rotateX(' + p.rotation.x + 'deg) rotateY(' + p.rotation.y + 'deg) rotateZ(' + p.rotation.z + 'deg);} 90%, 100% {transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);}}</style>')

	let style = {}

	style.wrapper = ''
	style.wrapper += 'width: ' + w + 'px;'
	style.wrapper += 'height: ' + h + 'px;'

	style.container = ''
	style.container += 'width: ' + w + 'px;'
	style.container += 'height: ' + h + 'px;'
	style.container += 'animation-name:' + animationName + ';'
	//style.container += 'animation-delay:' + p.delay + 's;'

	style.base = '';
	style.base += 'width: ' + p.base.w * w + 'px;'
	style.base += 'height: ' + p.base.h * h + 'px;'
	style.base += 'left:' + (p.l1.w + p.l2.w) * w + 'px;'
	style.base += 'top:' + p.t.h * h + 'px;'
	style.base += 'background-image: url(' + bg + ');'
	style.base += 'background-size: ' + w + 'px;'
	//style.base += 'animation-delay:' + p.delay + 's;'
	style.base += 'background-position:' + (p.l1.w + p.l2.w) * -w + 'px ' + (p.t.h) * -h + 'px;'

	style.t = ''
	style.t += 'width: ' + p.t.w * w + 'px;'
	style.t += 'height: ' + p.t.h * h + 'px;'
	style.t += 'left:0px;'
	style.t += 'top:0px;'
	style.t += 'background-image: url(' + bg + ');'
	style.t += 'background-size: ' + w + 'px;'
	//style.t += 'animation-delay:' + p.delay + 's;'
	style.t += 'background-position:0px 0px;'

	style.l1 = ''
	style.l1 += 'width: ' + p.l1.w * w + 'px;'
	style.l1 += 'height: ' + p.l1.h * h + 'px;'
	style.l1 += 'left:' + (p.l1.w) * -w + 'px;'
	style.l1 += 'top:' + p.tl1.h * h + 'px;'
	style.l1 += 'background-image: url(' + bg + ');'
	style.l1 += 'background-size: ' + w + 'px;'
	//style.l1 += 'animation-delay:' + p.delay + 's;'
	style.l1 += 'background-position:' + (p.l2.w) * -w + 'px ' + (p.t.h + p.tr1.h) * -h + 'px;'
	
	style.l2 = ''
	style.l2 += 'width: ' + p.l2.w * w + 'px;'
	style.l2 += 'height: ' + p.l2.h * h + 'px;'
	style.l2 += 'left:' + (p.l2.w) * -w + 'px;'
	style.l2 += 'top:0px;'
	style.l2 += 'background-image: url(' + bg + ');'
	style.l2 += 'background-size: ' + w + 'px;'
	//style.l2 += 'animation-delay:' + p.delay + 's;'
	style.l2 += 'background-position:0px ' + (p.t.h + p.tr1.h) * -h + 'px;'

	style.r1 = ''
	style.r1 += 'width: ' + p.r1.w * w + 'px;'
	style.r1 += 'height: ' + p.r1.h * h + 'px;'
	style.r1 += 'right:' + (p.r1.w) * -w + 'px;'
	style.r1 += 'top:' + p.tr1.h * h + 'px;'
	style.r1 += 'background-image: url(' + bg + ');'
	style.r1 += 'background-size: ' + w + 'px;'
	//style.r1 += 'animation-delay:' + p.delay + 's;'
	style.r1 += 'background-position:' + (p.l1.w + p.l2.w + p.base.w) * -w + 'px ' + (p.t.h + p.tr1.h) * -h + 'px;'

	style.r2 = ''
	style.r2 += 'width: ' + p.r2.w * w + 'px;'
	style.r2 += 'height: ' + p.r2.h * h + 'px;'
	style.r2 += 'right:' + (p.r2.w) * -w + 'px;'
	style.r2 += 'top:0px;'
	style.r2 += 'background-image: url(' + bg + ');'
	style.r2 += 'background-size: ' + w + 'px;'
	//style.r2 += 'animation-delay:' + p.delay + 's;'
	style.r2 += 'background-position:' + (p.l1.w + p.l2.w + p.base.w + p.r1.w) * -w + 'px ' + (p.t.h + p.tr1.h) * -h + 'px;'

	style.b = ''
	style.b += 'width: ' + p.b.w * w + 'px;'
	style.b += 'height: ' + p.b.h * h + 'px;'
	style.b += 'left: 0px;'
	style.b += 'top:' + (p.t.h + p.base.h) * h + 'px;'
	style.b += 'background-image: url(' + bg + ');'
	style.b += 'background-size: ' + w + 'px;'
	//style.b += 'animation-delay:' + p.delay + 's;'
	style.b += 'background-position:0px ' + (p.t.h + p.base.h) * -h + 'px;'

	style.tl3 = ''
	style.tl3 += 'width: ' + p.tl3.w * w + 'px;'
	style.tl3 += 'height: ' + p.tl3.h * h + 'px;'
	style.tl3 += 'left:0px;'
	style.tl3 += 'top:' + p.t.h * h + 'px;'
	style.tl3 += 'background-image: url(' + bg + ');'
	style.tl3 += 'background-size: ' + w + 'px;'
	//style.tl3 += 'animation-delay:' + p.delay + 's;'
	style.tl3 += 'background-position:0px ' + (p.t.h) * -h + 'px;'

	style.tr3 = ''
	style.tr3 += 'width: ' + p.tr3.w * w + 'px;'
	style.tr3 += 'height: ' + p.tr3.h * h + 'px;'
	style.tr3 += 'right:0px;'
	style.tr3 += 'top:' + p.t.h * h + 'px;'
	style.tr3 += 'background-image: url(' + bg + ');'
	style.tr3 += 'background-size: ' + w + 'px;'
	//style.tr3 += 'animation-delay:' + p.delay + 's;'
	style.tr3 += 'background-position:' + (p.l1.w + p.l2.w + p.base.w + p.r1.w) * -w + 'px ' + (p.t.h) * -h + 'px;'

	style.tl2 = ''
	style.tl2 += 'width: ' + p.tl2.w * w + 'px;'
	style.tl2 += 'height: ' + p.tl2.h * h + 'px;'
	style.tl2 += 'left:' + p.tl3.w * w + 'px;'
	style.tl2 += 'top:' + p.t.h * h + 'px;'
	style.tl2 += 'background-image: url(' + bg + ');'
	style.tl2 += 'background-size: ' + w + 'px;'
	//style.tl2 += 'animation-delay:' + p.delay + 's;'
	style.tl2 += 'background-position:' + (p.tl3.w) * -w + 'px ' + (p.t.h) * -h + 'px;'

	style.tr2 = ''
	style.tr2 += 'width: ' + p.tr2.w * w + 'px;'
	style.tr2 += 'height: ' + p.tr2.h * h + 'px;'
	style.tr2 += 'right:' + p.tr3.w * w + 'px;'
	style.tr2 += 'top:' + p.t.h * h + 'px;'
	style.tr2 += 'background-image: url(' + bg + ');'
	style.tr2 += 'background-size: ' + w + 'px;'
	//style.tr2 += 'animation-delay:' + p.delay + 's;'
	style.tr2 += 'background-position:' + (p.l1.w + p.l2.w + p.base.w) * -w + 'px ' + (p.t.h) * -h + 'px;'

	style.tl1 = ''
	style.tl1 += 'width: ' + p.tl1.w * w + 'px;'
	style.tl1 += 'height: ' + p.tl1.h * h + 'px;'
	style.tl1 += 'left:0px;'
	style.tl1 += 'top:' + p.tl1.h * -h + 'px;'
	style.tl1 += 'background-image: url(' + bg + ');'
	style.tl1 += 'background-size: ' + w + 'px;'
	//style.tl1 += 'animation-delay:' + p.delay + 's;'
	style.tl1 += 'background-position:' + (p.tl3.w) * -w + 'px ' + (p.t.h) * -h + 'px;'

	style.tr1 = ''
	style.tr1 += 'width: ' + p.tr1.w * w + 'px;'
	style.tr1 += 'height: ' + p.tr1.h * h + 'px;'
	style.tr1 += 'right:0px;'
	style.tr1 += 'top:' + p.tr1.h * -h + 'px;'
	style.tr1 += 'background-image: url(' + bg + ');'
	style.tr1 += 'background-size: ' + w + 'px;'
	//style.tr1 += 'animation-delay:' + p.delay + 's;'
	style.tr1 += 'background-position:' + (p.l1.w + p.l2.w + p.base.w) * -w + 'px ' + (p.t.h) * -h + 'px;'

	let dom = '';
	dom += '<div class="foldWrapper w-full sm:w-1/2 md:w-1/3 mb-24 inline-block">'
	dom += '	<div class="perspective" style="' + style.wrapper + '">'
	dom += '		<div class="container" style="' + style.container + '">'
	dom += '			<div class="t_t" style="' + style.t + '"></div>'
	dom += '			<div class="t_b" style="' + style.b + '"></div>'
	dom += '			<div class="t_tr2" style="' + style.tr2 + '"></div>'
	dom += '			<div class="t_tl2" style="' + style.tl2 + '"></div>'
	dom += '			<div class="t_tr3" style="' + style.tr3 + '"></div>'
	dom += '			<div class="t_tl3" style="' + style.tl3 + '"></div>'

	dom += '			<div class="t_base" style="' + style.base + '">'
	dom += '				<div class="t_r1" style="' + style.r1 + '">'
	dom += '					<div class="t_tr1" style="' + style.tr1 + '"></div>'
	dom += '					<div class="t_r2" style="' + style.r2 + '"></div>'
	dom += '				</div>'
	dom += '				<div class="t_l1" style="' + style.l1 + '">'
	dom += '					<div class="t_tl1" style="' + style.tl1 + '"></div>'
	dom += '					<div class="t_l2" style="' + style.l2 + '"></div>'
	dom += '				</div>'
	dom += '			</div>'
	dom += '		</div>'
	dom += '	</div>'
	dom += '</div>'

	let $elementToAppend = $(dom);
	$(container).append($elementToAppend);

	const elements = [
		[$elementToAppend.find('.container'), animationName],
		[$elementToAppend.find('.t_t'), "fadeAndShift"],
		[$elementToAppend.find('.t_b'), "fadeAndShift"],
		[$elementToAppend.find('.t_tl2'), "fadeAndShift"],
		[$elementToAppend.find('.t_tl3'), "fadeAndShift"],
		[$elementToAppend.find('.t_tr2'), "fadeAndShift"],
		[$elementToAppend.find('.t_tr3'), "fadeAndShift"],
		[$elementToAppend.find('.t_r1'), "foldYOutward"],
		[$elementToAppend.find('.t_r2'), "foldYOutward"],
		[$elementToAppend.find('.t_l1'), "foldYInward"],
		[$elementToAppend.find('.t_l2'), "foldYInward"],
	]

	initAnimations(elements, p.delay)
}

function generateTurningProperties(){
	let props = {
		rotation: {},
		delay: false
	}

	// Camera
	props.rotation = {
		x: Math.round(Math.random()*40 + 10), 
		y: Math.round(Math.random()*80 - 40),
		z: 0
	}
	props.delay = Math.random() * 10;

	return props;
}

function generateTurningDom (container, w, h, bg, p) {
	let randomID = Math.round(Math.random() * 10000);
	let animationName = 'tiltObject_' + randomID

	$('#animations').append('<style>@keyframes ' + animationName + ' { 0%, 10%  {transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);} 45%, 55%  {transform: rotateX(' + p.rotation.x + 'deg) rotateY(' + p.rotation.y + 'deg) rotateZ(' + p.rotation.z + 'deg);} 90%, 100% {transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg);}}</style>')

	let style = {
		wrapper: 'width: ' + w + 'px; height: ' + h + 'px;',
		container: 'width: ' + w + 'px; height: ' + h + 'px; animation-name:' + animationName + ';',
		rotateContainer: 'width: ' + w + 'px; height: ' + h + 'px; animation-name:rotateObject;',
		drilled: 'position:absolute;top:0;left:0;width:' + w +'px;height:' + h + 'px;background: url(' + bg + ');background-size: 100%;animation-name:moveDrill;',
		top: 'position:absolute;top:0;left:0;width:' + w +'px;height:' + h + 'px;background: url(' + bg + ');background-size: 100%;',
		ring1: 'position:absolute;top:0;left:0;width:' + w +'px;height:' + h + 'px;background: url(' + bg + ');background-size: 100%;animation-name:moveRing1;',
		ring2: 'position:absolute;top:0;left:0;width:' + w +'px;height:' + h + 'px;background: url(' + bg + ');background-size: 100%;animation-name:moveRing2;',
		waste: 'position:absolute;top:0;left:0;width:' + w +'px;height:' + h + 'px;background: url(' + bg + ');background-size: 100%;animation-name:fadeAndShift;',
	}

	let dom = '';

	dom += '<div class="foldWrapper w-full sm:w-1/2 md:w-1/3 mb-24 inline-block">'
	dom += '	<div class="perspective" style="' + style.wrapper + '">'
	dom += '		<div class="container" style="' + style.container + '">'
	dom += '			<div class="rotateContainer" style="' + style.rotateContainer + '">'
	dom += '				<div class="drilled" style="' + style.drilled + '"></div>'
	dom += '				<div class="top" style="' + style.top + '"></div>'
	dom += '				<div class="ring1" style="' + style.ring1 + '"></div>'
	dom += '				<div class="ring2" style="' + style.ring2 + '"></div>'
	dom += '				<div class="waste" style="' + style.waste + '"></div>'
	dom += '			</div>'
	dom += '		</div>'
	dom += '	</div>'
	dom += '</div>'

	let $elementToAppend = $(dom);
	$(container).append($elementToAppend);

	const elements = [
		[$elementToAppend.find('.container'), animationName],
		[$elementToAppend.find('.rotateContainer'), "rotateObject"],
		[$elementToAppend.find('.drilled'), "moveDrill"],
		[$elementToAppend.find('.ring1'), "moveRing1"],
		[$elementToAppend.find('.ring2'), "moveRing2"],
		[$elementToAppend.find('.waste'), "fadeAndShift"]
	]

	initAnimations(elements, p.delay)
}