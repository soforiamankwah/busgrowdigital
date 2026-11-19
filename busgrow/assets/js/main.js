/* Busgrow theme scripts: mobile menu, portfolio filter, hero animation, analytics card, approach reveal */
(function(){
var nav=document.getElementById("nav"),burger=document.getElementById("burger");
if(nav&&burger){
burger.addEventListener("click",function(){var o=nav.classList.toggle("open");burger.setAttribute("aria-expanded",o)});
nav.addEventListener("click",function(e){if(e.target.closest("a")){nav.classList.remove("open");burger.setAttribute("aria-expanded","false")}});
}
var fl=document.getElementById("filters");
if(fl){fl.addEventListener("click",function(e){var b=e.target.closest(".fbtn");if(!b)return;
[].forEach.call(document.querySelectorAll(".fbtn"),function(x){x.classList.toggle("on",x===b)});
[].forEach.call(document.querySelectorAll(".work"),function(w){w.classList.toggle("hide",b.dataset.f!=="all"&&w.dataset.c!==b.dataset.f)})});}
})();

(function(){if(!document.getElementById("hv"))return;var c=document.getElementById("hv"),x=c.getContext("2d"),W=0,H=0,t=0,P=[],rm=matchMedia("(prefers-reduced-motion:reduce)").matches,i;
for(i=0;i<70;i++)P.push({x:Math.random(),y:Math.random(),s:.04+Math.random()*.08,r:.8+Math.random()*2.2});
function rs(){var d=Math.min(devicePixelRatio||1,2);W=c.parentNode.clientWidth;H=c.parentNode.clientHeight;c.width=W*d;c.height=H*d;x.setTransform(d,0,0,d,0,0)}
function wave(k,al,off){x.beginPath();for(var px=0;px<=W;px+=8){var u=px/W,y=H*(.78-.3*u)+Math.sin(u*6+t*.6*k+off)*H*.05*k+Math.sin(u*13-t*.9+off)*H*.015;px?x.lineTo(px,y):x.moveTo(px,y)}x.strokeStyle="rgba(255,107,112,"+al+")";x.lineWidth=1.5;x.stroke()}
function gy(u){return H*(.86-.58*Math.pow(u,1.35))+Math.sin(u*16)*H*.018}
function draw(){
if(c.parentNode.clientWidth!==W||c.parentNode.clientHeight!==H)rs();
if(!W)return;x.clearRect(0,0,W,H);
var n=Math.max(8,Math.round(W/70)),bw=W/n,g;
for(i=0;i<n;i++){var u=i/(n-1),h=H*(.1+.5*u)*(.82+.18*Math.sin(t*.9+i*.7));g=x.createLinearGradient(0,H-h,0,H);g.addColorStop(0,"rgba(229,27,35,.38)");g.addColorStop(1,"rgba(168,8,18,0)");x.fillStyle=g;x.fillRect(i*bw+bw*.18,H-h,bw*.64,h)}
wave(1,.22,0);wave(1.4,.15,2);wave(.7,.12,4);
for(i=0;i<P.length;i++){var p=P[i];if(!rm)p.y-=p.s*.003*60/60;if(p.y<-.02){p.y=1.02;p.x=Math.random()}x.beginPath();x.arc(p.x*W,p.y*H,p.r,0,6.3);x.fillStyle="rgba(255,150,153,"+(.15+.35*p.s*6)+")";x.fill()}
var pr=(t*.14)%1.45,k=Math.min(pr,1),al=pr>1?Math.max(0,1-(pr-1)*2.2):1,N=70,m=Math.max(2,Math.floor(N*k)),lx,ly,ax,ay;
x.save();x.globalAlpha=al;x.shadowColor="#FF6B70";x.shadowBlur=22;x.lineWidth=4;x.lineCap="round";x.lineJoin="round";
g=x.createLinearGradient(0,0,W,0);g.addColorStop(0,"rgba(229,27,35,.2)");g.addColorStop(1,"#FF6B70");x.strokeStyle=g;x.beginPath();
for(i=0;i<=m;i++){var uu=.04+.92*(i/N);lx=uu*W;ly=gy(uu);i?x.lineTo(lx,ly):x.moveTo(lx,ly);if(i==m-1){ax=lx;ay=ly}}x.stroke();
var an=Math.atan2(ly-ay,lx-ax);x.translate(lx,ly);x.rotate(an);x.fillStyle="#FF6B70";x.beginPath();x.moveTo(16,0);x.lineTo(-10,-11);x.lineTo(-5,0);x.lineTo(-10,11);x.closePath();x.fill();x.restore()}
function loop(){t+=.016;draw();if(!rm)requestAnimationFrame(loop)}
if(rm){t=3.2;draw();window.addEventListener("hashchange",function(){setTimeout(draw,60)});window.addEventListener("resize",draw)}else loop();
})();

(function(){if(!document.getElementById("fw"))return;var fa=document.getElementById("fa"),fb=document.getElementById("fb"),fc=document.getElementById("fc"),fd=document.getElementById("fd"),fw=document.getElementById("fw"),rot=0,cur=0,front=true,busy=false,hov=false,rmo=matchMedia("(prefers-reduced-motion:reduce)").matches;
function head(t,d){return '<div class="ph"><span>'+t+'</span><small>'+d+'</small></div>'}
function kp(v,l,d){return '<div class="k"><b>'+v+(d?'<i>'+d+'</i>':'')+'</b><span>'+l+'</span></div>'}
function foot(){return '<div class="pf">Sample data</div>'}
function spark(a){var n=a.length,mx=Math.max.apply(null,a),mn=Math.min.apply(null,a),l=a.map(function(v,i){return (i?"L":"M")+(i*300/(n-1)).toFixed(1)+" "+(80-(v-mn)/(mx-mn)*66).toFixed(1)}).join(" ");return '<svg class="ch" viewBox="0 0 300 90" preserveAspectRatio="none" aria-hidden="true"><path d="'+l+' L300 90 L0 90Z" fill="rgba(229,27,35,.12)"/><path d="'+l+'" fill="none" stroke="#E51B23" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke"/></svg>'}
function bars(a){var mx=Math.max.apply(null,a),w=300/a.length;return '<svg class="ch" viewBox="0 0 300 90" aria-hidden="true">'+a.map(function(v,i){var h=v/mx*82;return '<rect x="'+(i*w+5)+'" y="'+(88-h)+'" width="'+(w-10)+'" height="'+h+'" rx="5" fill="'+(i==a.length-1?"#E51B23":"#FF6B70")+'" opacity="'+(.4+.6*i/(a.length-1)).toFixed(2)+'"/>'}).join("")+'</svg>'}
function rk(p,k,c,sec){return '<div class="rk"><span class="pos'+(sec?" s":"")+'">#'+p+'</span><span>'+k+'</span><span class="up">▲ '+c+'</span></div>'}
var P=[
head("Google Search Console","Last 28 days")+'<div class="kg">'+kp("12.4K","Total clicks","+41%")+kp("318K","Impressions","+57%")+kp("3.9%","Avg. CTR","+0.8")+kp("8.2","Avg. position","▲ 6.1")+'</div>'+spark([22,26,25,31,35,34,42,47,52,58,66,78])+foot(),
head("GA4 Analytics","Last 30 days")+'<div class="kg">'+kp("24.8K","Users","+38%")+kp("41.2K","Sessions","+44%")+kp("64%","Engagement rate","+9%")+kp("1,284","Conversions","+72%")+'</div>'+bars([30,38,35,46,52,60,74])+foot(),
head("SEO Keyword Rankings","Google · Top results")+'<div>'+rk(1,"digital marketing agency",5)+rk(2,"search engine optimization services",4)+rk(3,"online business marketing",7,1)+rk(4,"website design for small business",3,1)+'</div>'+foot(),
head("Growth Overview","Year over year")+'<div class="big"><b>+212%</b><span>Organic traffic growth</span></div>'+spark([8,10,9,14,18,22,30,41,55,70,92,120])+'<div class="kg">'+kp("4.8x","Return on ad spend")+kp("−37%","Cost per lead")+'</div>'+foot(),
head("Social Media Growth","Last 30 days")+'<div class="kg">'+kp("486K","Impressions","+62%")+kp("8.4%","Engagement rate","+2.1")+kp("19.7K","Link clicks","+54%")+kp("6.2K","New followers","+31%")+'</div>'+spark([14,16,15,21,26,24,33,41,46,58,66,80])+foot(),
head("Email Marketing","Last 90 days")+'<div class="kg">'+kp("128K","Emails sent")+kp("46.8%","Open rate","+8.3")+kp("2,340","Leads generated","+66%")+kp("0.2%","Unsubscribe rate","Very low")+'</div>'+bars([32,36,41,39,45,52,58])+foot()];
fd.innerHTML=P.map(function(_,i){return '<button type="button" aria-label="Show report '+(i+1)+'"'+(i?'':' class="on"')+'></button>'}).join("");
fa.innerHTML=P[0];
function show(n){if(busy||n===cur)return;busy=true;(front?fb:fa).innerHTML=P[n];rot+=180;fc.style.transform="rotateY("+rot+"deg)";front=!front;cur=n;[].forEach.call(fd.children,function(b,i){b.classList.toggle("on",i===n)});setTimeout(function(){busy=false},rmo?50:950)}
fd.addEventListener("click",function(e){var i=[].indexOf.call(fd.children,e.target);if(i>-1)show(i)});
fc.addEventListener("click",function(){show((cur+1)%P.length)});
fw.addEventListener("mouseenter",function(){hov=true});fw.addEventListener("mouseleave",function(){hov=false});
if(!rmo)setInterval(function(){if(!hov&&fw.offsetWidth&&!document.hidden)show((cur+1)%P.length)},5200);
})();

(function(){var tl=document.querySelector(".tl");if(!tl||!("IntersectionObserver" in window)||matchMedia("(prefers-reduced-motion:reduce)").matches)return;
tl.classList.add("rv");var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add("in");io.unobserve(e.target)}})},{threshold:.3});
[].forEach.call(tl.children,function(i){io.observe(i)})})();
