var $=function(i){return document.getElementById(i)},sl=function(ms){return new Promise(function(r){setTimeout(r,ms)})};
var flip=$('flip'),run=0;
function count(el,to){if(!el)return;var s=null;(function f(t){s=s||t;var k=Math.min((t-s)/1800,1);el.textContent=Math.floor(to*(1-Math.pow(1-k,3))).toLocaleString('en-IN')+(k==1?'+':'');if(k<1)requestAnimationFrame(f)})(0)}
count($('c1'),100);count($('c2'),5000);
function confetti(){var b=$('bk');if(!b)return;var c=['#ff9933','#ffffff','#4cc15f','#ffd9a8'];b.querySelectorAll('.cf').forEach(function(x){x.remove()});for(var i=0;i<24;i++){var e=document.createElement('span');e.className='cf';e.style.left=Math.random()*100+'%';e.style.background=c[i%4];e.style.animationDelay=Math.random()*2+'s';b.appendChild(e)}}
async function flipToBackAndDismiss(id){
  var T=document.querySelectorAll('.toast');
  confetti();
  flip.classList.add('back');
  if(T[2])T[2].classList.add('on');
  await sl(1000);if(id!=run)return;
  if(T[0])T[0].classList.remove('on');
  await sl(600);if(id!=run)return;
  if(T[1])T[1].classList.remove('on');
  await sl(600);if(id!=run)return;
  if(T[2])T[2].classList.remove('on');
  await sl(2800);if(id!=run)return;
  cycle(id);
}
async function cycle(id){
  if(!flip)return;
  var sp=document.querySelectorAll('#sk span'),ln=document.querySelectorAll('.ln'),T=document.querySelectorAll('.toast');
  flip.classList.remove('back');await sl(900);if(id!=run)return;
  if($('nm'))$('nm').textContent='';sp.forEach(function(x){x.classList.remove('on')});ln.forEach(function(x){x.classList.remove('on')});
  if($('stamp'))$('stamp').classList.remove('on');if($('bar'))$('bar').style.width='0';if($('pc'))$('pc').textContent='0%';T.forEach(function(x){x.classList.remove('on')});
  var n='Aarav Mehta';
  for(var i=1;i<=n.length;i++){if($('nm'))$('nm').textContent=n.slice(0,i);await sl(90);if(id!=run)return}
  if(T[0])T[0].classList.add('on');
  for(var j=0;j<sp.length;j++){sp[j].classList.add('on');await sl(260)}
  ln.forEach(function(x){x.classList.add('on')});
  if($('bar'))$('bar').style.width='92%';var v=0,iv=setInterval(function(){v=Math.min(92,v+3);if($('pc'))$('pc').textContent=v+'%';if(v>=92)clearInterval(iv)},45);
  await sl(1500);if(id!=run)return;
  if($('stamp'))$('stamp').classList.add('on');if(T[1])T[1].classList.add('on');await sl(1800);if(id!=run)return;
  await flipToBackAndDismiss(id);
}
cycle(++run);
var sceneEl=$('scene');
if(sceneEl){
  sceneEl.onclick=function(){run++;var me=run;if(flip.classList.contains('back')){cycle(me)}else{flipToBackAndDismiss(me)}};
}

// Button actions
document.addEventListener('DOMContentLoaded', function() {
  var regBtn = document.querySelector('.cta .btn.p');
  if (regBtn) {
    regBtn.addEventListener('click', function(e) {
      e.preventDefault();
      var f = document.getElementById('registerForm');
      if (f) f.scrollIntoView({ behavior: 'smooth' });
    });
  }
  var compBtn = document.querySelector('.cta .btn:not(.p)');
  if (compBtn) {
    compBtn.addEventListener('click', function(e) {
      e.preventDefault();
      window.location.href = 'company.html';
    });
  }
});
