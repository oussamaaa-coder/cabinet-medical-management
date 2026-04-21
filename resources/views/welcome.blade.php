<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MediCal — Cabinet Médical</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Nunito:wght@300;400;500;600&family=Petit+Formal+Script&display=swap" rel="stylesheet">
<style>
:root {
  --cream:     #f0f5f2;
  --cream-2:   #e4ede8;
  --cream-3:   #d8e8e1;
  --parch:     #ffffff;
  --terra:     #2d8f6f;
  --terra-lt:  #e4f4ed;
  --terra-dk:  #1a6e53;
  --terra-mid: #1f8563;
  --sand:      #7da090;
  --sand-2:    #4a6e5c;
  --bark:      #111e17;
  --bark-2:    #2d4438;
  --bark-3:    #4a6e5c;
  --sage:      #2d8f6f;
  --sage-lt:   #e4f4ed;
  --nav-h:     72px;
  --ease:      cubic-bezier(.4,0,.2,1);
  --spring:    cubic-bezier(.34,1.56,.64,1);
  --out:       cubic-bezier(.22,1,.36,1);
  --r-sm:8px; --r-md:16px; --r-lg:28px; --r-xl:48px;
}
[data-theme="dark"] {
  --cream:     #0d1912;
  --cream-2:   #112218;
  --cream-3:   #1f3329;
  --parch:     #162118;
  --terra:     #4ead7e;
  --terra-lt:  #1a2d23;
  --terra-dk:  #3d9a6c;
  --terra-mid: #2d8f6f;
  --sand:      #46705c;
  --sand-2:    #6a9e88;
  --bark:      #d8ede4;
  --bark-2:    #93bfaa;
  --bark-3:    #6a9e88;
  --sage:      #4ead7e;
  --sage-lt:   #1a2818;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'Nunito',sans-serif;background:var(--cream);color:var(--bark);overflow-x:hidden;transition:background .35s,color .35s;-webkit-font-smoothing:antialiased}
body::before{content:'';position:fixed;inset:0;pointer-events:none;z-index:9999;opacity:.022;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");mix-blend-mode:multiply}
a{text-decoration:none;color:inherit}
img{display:block;max-width:100%}
button{font-family:inherit;cursor:pointer}

#prog{position:fixed;top:0;left:0;right:0;height:2px;z-index:1001;background:linear-gradient(90deg,var(--terra),var(--terra-mid));transform-origin:left;transform:scaleX(0);transition:transform .1s linear;border-radius:0 2px 2px 0}

/* NAV */
.nav{position:fixed;top:0;left:0;right:0;z-index:900;height:var(--nav-h);display:flex;align-items:center;justify-content:space-between;padding:0 clamp(20px,5vw,72px);transition:background .4s,box-shadow .4s}
.nav.solid{background:color-mix(in srgb,var(--parch) 94%,transparent);backdrop-filter:blur(20px);box-shadow:0 1px 24px rgba(17,30,23,.07)}
.nav-logo{display:flex;align-items:center;gap:11px}
.nav-emblem{width:42px;height:42px;display:flex;align-items:center;justify-content:center;transition:transform .3s var(--spring);flex-shrink:0}
.nav-emblem img{width:100%;height:100%;object-fit:contain}
.nav-logo:hover .nav-emblem{transform:scale(1.1) rotate(-5deg)}
.nav-emblem svg{width:18px;height:18px;fill:none;stroke:#fff;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}
.nav-brand{font-family:'Lora',serif;font-size:22px;font-weight:700;color:var(--bark);letter-spacing:-.02em;line-height:1}
.nav-brand span{color:var(--terra);font-weight:600}
.nav-tagline{font-size:11px;font-weight:500;color:var(--sand);letter-spacing:.05em;text-transform:uppercase;margin-top:2px;opacity:.8}
.nav-links{display:flex;align-items:center;gap:2px;list-style:none}
.nav-links a{display:block;padding:7px 15px;border-radius:var(--r-sm);font-size:14px;font-weight:400;color:var(--bark-3);transition:background .2s,color .2s}
.nav-links a:hover{background:var(--cream-2);color:var(--bark)}
.nav-right{display:flex;align-items:center;gap:8px}
.btn-soft{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--r-sm);border:1.5px solid var(--cream-3);background:transparent;font-size:13px;font-weight:500;color:var(--bark-2);transition:all .2s}
.btn-soft:hover{border-color:var(--terra-mid);color:var(--terra);background:var(--terra-lt)}
.btn-warm{display:inline-flex;align-items:center;gap:7px;padding:10px 20px;border-radius:var(--r-sm);background:var(--terra);color:#fff;border:none;font-size:13px;font-weight:600;letter-spacing:.015em;box-shadow:0 4px 18px rgba(45,143,111,.28);transition:all .25s}
.btn-warm:hover{background:var(--terra-dk);box-shadow:0 6px 26px rgba(45,143,111,.38);transform:translateY(-1px)}
.btn-soft svg,.btn-warm svg{width:13px;height:13px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
.theme-btn{width:36px;height:36px;border-radius:var(--r-sm);border:1.5px solid var(--cream-3);background:transparent;display:flex;align-items:center;justify-content:center;color:var(--sand-2);transition:all .2s}
.theme-btn:hover{background:var(--cream-2);color:var(--bark)}
.theme-btn svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
.ham-btn{display:none;flex-direction:column;gap:5px;width:36px;height:36px;align-items:center;justify-content:center;border:1.5px solid var(--cream-3);border-radius:var(--r-sm);background:transparent}
.ham-btn span{display:block;width:17px;height:1.5px;background:var(--bark-3);border-radius:1px;transition:all .25s}
.ham-btn.open span:nth-child(1){transform:rotate(45deg) translate(4.5px,4.5px)}
.ham-btn.open span:nth-child(2){opacity:0}
.ham-btn.open span:nth-child(3){transform:rotate(-45deg) translate(4.5px,-4.5px)}
.mob-menu{display:none;position:fixed;inset:0;top:var(--nav-h);background:var(--parch);z-index:850;flex-direction:column;padding:32px 24px;gap:6px;animation:slideDown .24s var(--out)}
.mob-menu.open{display:flex}
.mob-menu a{display:block;padding:13px 16px;font-size:16px;color:var(--bark-2);border-bottom:1px solid var(--cream-2)}
.mob-cta{display:flex;flex-direction:column;gap:10px;margin-top:20px}
.mob-cta .btn-soft,.mob-cta .btn-warm{justify-content:center;padding:13px;font-size:14px;border-radius:var(--r-sm)}
@keyframes slideDown{from{opacity:0;transform:translateY(-10px)}to{opacity:1;transform:none}}

/* HERO */
.hero{min-height:100vh;padding:calc(var(--nav-h) + 64px) clamp(20px,5vw,72px) 80px;display:flex;flex-direction:column;align-items:center;justify-content:center;position:relative;overflow:hidden;text-align:center}
.hero-blob{position:absolute;border-radius:50%;filter:blur(70px);pointer-events:none}
.hero-blob-1{width:500px;height:500px;background:radial-gradient(circle,rgba(45,143,111,.12) 0%,transparent 70%);top:-80px;right:-100px;animation:blobF 10s ease-in-out infinite}
.hero-blob-2{width:380px;height:380px;background:radial-gradient(circle,rgba(125,160,144,.14) 0%,transparent 70%);bottom:-60px;left:-80px;animation:blobF 13s ease-in-out 2s infinite reverse}
.hero-blob-3{width:260px;height:260px;background:radial-gradient(circle,rgba(45,143,111,.10) 0%,transparent 70%);top:40%;right:8%;animation:blobF 9s ease-in-out 1s infinite}
@keyframes blobF{0%,100%{transform:translateY(0) scale(1)}50%{transform:translateY(-28px) scale(1.04)}}
.hero-arc{position:absolute;top:-60px;right:-60px;width:320px;height:320px;border-radius:50%;border:1px solid var(--cream-3);pointer-events:none;opacity:.6}
.hero-arc-2{position:absolute;top:30px;right:30px;width:200px;height:200px;border-radius:50%;border:1px solid color-mix(in srgb,var(--terra) 20%,transparent);pointer-events:none}
.hero-inner{position:relative;z-index:1;max-width:780px;margin:0 auto}
.hero-script{font-family:'Petit Formal Script',cursive;font-size:clamp(1.1rem,2.5vw,1.5rem);color:var(--terra-mid);margin-bottom:16px;opacity:0;animation:fadeUp .7s var(--out) .1s forwards}
.hero-title{font-family:'Lora',serif;font-size:clamp(3rem,7vw,5.6rem);font-weight:700;line-height:1.06;letter-spacing:-.03em;color:var(--bark);margin-bottom:24px;opacity:0;animation:fadeUp .75s var(--out) .2s forwards}
.hero-title em{font-style:italic;font-weight:400;color:var(--terra)}
.hero-sub{font-size:clamp(1rem,2vw,1.15rem);line-height:1.85;color:var(--bark-3);max-width:560px;margin:0 auto 44px;font-weight:300;opacity:0;animation:fadeUp .75s var(--out) .3s forwards}
.hero-ctas{display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap;margin-bottom:64px;opacity:0;animation:fadeUp .75s var(--out) .4s forwards}
.hero-ctas .btn-warm{padding:14px 30px;font-size:15px;border-radius:var(--r-md)}
.hero-ctas .btn-soft{padding:13px 30px;font-size:15px;border-radius:var(--r-md)}
.hero-stats{display:inline-flex;align-items:stretch;background:var(--parch);border:1px solid var(--cream-3);border-radius:var(--r-xl);overflow:hidden;box-shadow:0 8px 40px rgba(17,30,23,.07),0 1px 0 rgba(255,255,255,.6) inset;opacity:0;animation:fadeUp .75s var(--out) .5s forwards}
.hero-stat{padding:22px 36px;text-align:center;position:relative;cursor:default;transition:background .2s}
.hero-stat:hover{background:var(--cream-2)}
.hero-stat+.hero-stat::before{content:'';position:absolute;left:0;top:18%;height:64%;width:1px;background:var(--cream-3)}
.hero-stat-val{font-family:'Lora',serif;font-size:1.9rem;font-weight:700;color:var(--terra);line-height:1;margin-bottom:5px;letter-spacing:-.02em}
.hero-stat-lbl{font-size:11px;color:var(--sand);letter-spacing:.04em;text-transform:uppercase;font-weight:500}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}

/* SHARED */
.reveal{opacity:0;transform:translateY(22px);transition:opacity .65s var(--ease),transform .65s var(--ease)}
.reveal.on{opacity:1;transform:none}
.eyebrow{display:inline-flex;align-items:center;gap:8px;font-family:'Lora',serif;font-size:13px;font-style:italic;color:var(--terra);margin-bottom:12px}
.eyebrow-dot{width:6px;height:6px;border-radius:50%;background:var(--terra-mid)}
.sh2{font-family:'Lora',serif;font-size:clamp(2.1rem,4vw,3.2rem);font-weight:700;line-height:1.1;letter-spacing:-.025em;color:var(--bark);margin-bottom:18px}
.sh2 em{font-style:italic;font-weight:400;color:var(--terra)}
.sh-sub{font-size:1.02rem;color:var(--bark-3);line-height:1.8;font-weight:300;max-width:500px}

/* SERVICES */
#services{padding:100px clamp(20px,5vw,72px);background:var(--cream-2);position:relative}
#services::before{content:'';position:absolute;top:-1px;left:0;right:0;height:60px;background:var(--cream);border-radius:0 0 50% 50% / 0 0 60px 60px}
.services-top{display:flex;align-items:flex-end;justify-content:space-between;gap:40px;margin-bottom:56px;flex-wrap:wrap}
.services-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.svc{background:var(--parch);border:1px solid var(--cream-3);border-radius:var(--r-lg);padding:36px 30px;position:relative;overflow:hidden;transition:transform .35s var(--out),box-shadow .35s var(--out),border-color .35s;cursor:default}
.svc:hover{transform:translateY(-6px);box-shadow:0 16px 48px rgba(17,30,23,.1);border-color:color-mix(in srgb,var(--terra) 25%,var(--cream-3))}
.svc::before{content:'';position:absolute;inset:0;border-radius:var(--r-lg);background:radial-gradient(circle at 50% 0%,rgba(193,100,74,.06) 0%,transparent 60%);opacity:0;transition:opacity .35s}
.svc:hover::before{opacity:1}
.svc-icon{width:52px;height:52px;border-radius:var(--r-md);background:var(--terra-lt);display:flex;align-items:center;justify-content:center;margin-bottom:22px;transition:background .3s,transform .3s var(--spring)}
.svc:hover .svc-icon{background:var(--terra);transform:scale(1.08) rotate(-4deg)}
.svc-icon svg{width:22px;height:22px;fill:none;stroke:var(--terra);stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round;transition:stroke .3s}
.svc:hover .svc-icon svg{stroke:#fff}
.svc-title{font-family:'Lora',serif;font-size:1.15rem;font-weight:600;color:var(--bark);margin-bottom:10px;line-height:1.25;letter-spacing:-.01em}
.svc-body{font-size:.875rem;color:var(--bark-3);line-height:1.75;font-weight:300;margin-bottom:18px}
.svc-pill{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:20px;background:var(--terra-lt);font-size:10.5px;font-weight:600;letter-spacing:.04em;text-transform:uppercase;color:var(--terra)}
.svc:first-child{grid-column:span 2;background:linear-gradient(145deg,var(--terra) 0%,var(--terra-dk) 100%);border-color:transparent}
.svc:first-child .svc-icon{background:rgba(255,255,255,.18)}
.svc:first-child .svc-icon svg{stroke:#fff}
.svc:first-child:hover .svc-icon{background:rgba(255,255,255,.28)}
.svc:first-child .svc-title{color:#fff;font-size:1.35rem}
.svc:first-child .svc-body{color:rgba(255,255,255,.75)}
.svc:first-child .svc-pill{background:rgba(255,255,255,.2);color:#fff}
.svc:first-child::before{background:none}
.svc:first-child:hover{box-shadow:0 20px 60px rgba(45,143,111,.35);border-color:transparent}
.svc:first-child::after{content:'';position:absolute;top:-50px;right:-50px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.07);pointer-events:none}

/* HOW */
#how{padding:100px clamp(20px,5vw,72px);background:var(--cream)}
.how-inner{display:grid;grid-template-columns:1fr 2fr;gap:80px;align-items:start}
.how-left{position:sticky;top:calc(var(--nav-h) + 40px)}
.how-steps{display:flex;flex-direction:column;gap:0}
.step{display:flex;gap:28px;padding:36px 0;border-bottom:1px solid var(--cream-2);align-items:flex-start}
.step:first-child{border-top:1px solid var(--cream-2)}
.step-num-wrap{flex-shrink:0;width:56px;height:56px;border-radius:50%;border:1.5px solid var(--cream-3);background:var(--parch);display:flex;align-items:center;justify-content:center;transition:all .3s var(--spring)}
.step:hover .step-num-wrap{background:var(--terra);border-color:var(--terra);transform:scale(1.08);box-shadow:0 6px 20px rgba(45,143,111,.28)}
.step-num{font-family:'Lora',serif;font-size:1.2rem;font-weight:700;color:var(--bark-3);transition:color .3s}
.step:hover .step-num{color:#fff}
.step-content{flex:1;padding-top:4px}
.step-title{font-family:'Lora',serif;font-size:1.15rem;font-weight:600;color:var(--bark);margin-bottom:8px;letter-spacing:-.01em}
.step-body{font-size:.875rem;color:var(--bark-3);line-height:1.75;font-weight:300}
.how-dots{display:flex;gap:6px;margin-top:32px}
.how-dot{width:8px;height:8px;border-radius:50%;background:var(--cream-3);transition:background .3s,transform .3s}
.how-dot.active{background:var(--terra);transform:scale(1.3)}

/* PORTALS */
#portals{padding:0 clamp(20px,5vw,72px) 100px;background:var(--cream)}
.portals-header{text-align:center;max-width:560px;margin:0 auto 56px}
.portals-header .sh-sub{margin:0 auto}
.portals-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:900px;margin:0 auto}
.portal{border-radius:var(--r-xl);padding:52px 44px;position:relative;overflow:hidden;transition:transform .35s var(--out),box-shadow .35s}
.portal:hover{transform:translateY(-8px)}
.portal-patient{background:linear-gradient(145deg,var(--bark) 0%,var(--bark-2) 100%);box-shadow:0 10px 48px rgba(17,30,23,.2)}
.portal-staff{background:var(--parch);border:1.5px solid var(--cream-3);box-shadow:0 4px 24px rgba(17,30,23,.06)}
.portal-staff:hover{box-shadow:0 16px 52px rgba(17,30,23,.1)}
.portal-arc{position:absolute;border-radius:50%;pointer-events:none}
.portal-patient .portal-arc:nth-child(1){width:200px;height:200px;top:-60px;right:-60px;border:1px solid rgba(255,255,255,.08)}
.portal-patient .portal-arc:nth-child(2){width:130px;height:130px;bottom:-30px;right:50px;border:1px solid rgba(255,255,255,.05)}
.portal-tag{display:inline-block;font-size:10.5px;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:5px 14px;border-radius:20px;margin-bottom:20px;font-family:'Nunito',sans-serif}
.portal-patient .portal-tag{background:rgba(255,255,255,.1);color:rgba(255,255,255,.65)}
.portal-staff   .portal-tag{background:var(--terra-lt);color:var(--terra)}
.portal-title{font-family:'Lora',serif;font-size:clamp(1.8rem,2.8vw,2.5rem);font-weight:700;line-height:1.1;letter-spacing:-.025em;margin-bottom:14px}
.portal-patient .portal-title{color:#fff}
.portal-staff   .portal-title{color:var(--bark)}
.portal-patient .portal-title em{font-weight:400;color:var(--terra-mid)}
.portal-staff   .portal-title em{font-weight:400;color:var(--terra)}
.portal-body{font-size:.9rem;line-height:1.8;font-weight:300;margin-bottom:28px}
.portal-patient .portal-body{color:rgba(255,255,255,.62)}
.portal-staff   .portal-body{color:var(--bark-3)}
.portal-list{list-style:none;margin-bottom:36px;display:flex;flex-direction:column;gap:0}
.portal-list li{display:flex;align-items:center;gap:12px;font-size:.875rem;padding:10px 0;border-bottom:1px solid}
.portal-patient .portal-list li{color:rgba(255,255,255,.75);border-color:rgba(255,255,255,.1)}
.portal-staff   .portal-list li{color:var(--bark-2);border-color:var(--cream-2)}
.portal-list li::before{content:'';width:18px;height:18px;border-radius:50%;flex-shrink:0;background-repeat:no-repeat;background-position:center;background-size:10px}
.portal-patient .portal-list li::before{background-color:rgba(255,255,255,.12);background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2 6l3 3 5-5' stroke='white' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round' fill='none'/%3E%3C/svg%3E")}
.portal-staff   .portal-list li::before{background-color:var(--terra-lt);background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12'%3E%3Cpath d='M2 6l3 3 5-5' stroke='%23c1644a' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round' fill='none'/%3E%3C/svg%3E")}
.portal-btn{display:inline-flex;align-items:center;gap:8px;padding:14px 26px;border-radius:var(--r-md);font-size:14px;font-weight:600;border:none;cursor:pointer;font-family:'Nunito',sans-serif;letter-spacing:.01em;transition:all .25s;position:relative;overflow:hidden}
.portal-btn::before{content:'';position:absolute;top:0;left:-100%;width:60%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent);transform:skewX(-20deg);transition:left .5s var(--out)}
.portal-btn:hover::before{left:160%}
.portal-patient .portal-btn{background:#fff;color:var(--terra)}
.portal-patient .portal-btn:hover{background:var(--terra-lt)}
.portal-staff   .portal-btn{background:var(--terra);color:#fff;box-shadow:0 4px 18px rgba(45,143,111,.28)}
.portal-staff   .portal-btn:hover{background:var(--terra-dk);box-shadow:0 6px 28px rgba(45,143,111,.38);transform:translateY(-2px)}
.portal-btn svg{width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

/* TRUST STRIP */
.trust-strip{margin:0 clamp(20px,5vw,72px) 80px;background:var(--terra-lt);border:1px solid color-mix(in srgb,var(--terra) 15%,transparent);border-radius:var(--r-xl);padding:48px clamp(28px,5vw,72px);display:flex;align-items:center;gap:60px;flex-wrap:wrap;justify-content:space-between}
.trust-quote{flex:1;min-width:260px}
.trust-quote-mark{font-family:'Lora',serif;font-size:3rem;color:var(--terra-mid);line-height:1;margin-bottom:8px;opacity:.5}
.trust-quote-text{font-family:'Lora',serif;font-size:1.1rem;font-style:italic;color:var(--bark-2);line-height:1.7;font-weight:400;margin-bottom:14px}
.trust-quote-author{font-size:12.5px;font-weight:600;color:var(--terra);letter-spacing:.04em;text-transform:uppercase}
.trust-metrics{display:flex;gap:40px;flex-wrap:wrap}
.trust-metric{text-align:center}
.trust-metric-val{font-family:'Lora',serif;font-size:2.2rem;font-weight:700;color:var(--terra);line-height:1;margin-bottom:4px}
.trust-metric-lbl{font-size:11px;color:var(--sand-2);letter-spacing:.04em;text-transform:uppercase;font-weight:500}

/* CTA */
#cta{padding:0 clamp(20px,5vw,72px) 100px}
.cta-card{background:linear-gradient(145deg,var(--terra) 0%,var(--terra-dk) 100%);border-radius:var(--r-xl);padding:80px clamp(32px,6vw,96px);text-align:center;position:relative;overflow:hidden;box-shadow:0 20px 80px rgba(45,143,111,.28)}
.cta-arc-1{position:absolute;width:300px;height:300px;border-radius:50%;top:-80px;right:-80px;border:1px solid rgba(255,255,255,.08);pointer-events:none}
.cta-arc-2{position:absolute;width:180px;height:180px;border-radius:50%;bottom:-40px;left:80px;border:1px solid rgba(255,255,255,.06);pointer-events:none}
.cta-script{font-family:'Petit Formal Script',cursive;font-size:1.3rem;color:rgba(255,255,255,.55);margin-bottom:12px}
.cta-h{font-family:'Lora',serif;font-size:clamp(2.2rem,5vw,3.8rem);font-weight:700;color:#fff;line-height:1.06;letter-spacing:-.03em;margin-bottom:16px}
.cta-h em{font-style:italic;font-weight:400;color:rgba(255,255,255,.7)}
.cta-p{font-size:1.02rem;color:rgba(255,255,255,.65);max-width:480px;margin:0 auto 40px;line-height:1.8;font-weight:300}
.cta-btns{display:flex;align-items:center;justify-content:center;gap:12px;flex-wrap:wrap}
.cta-btn-cream{display:inline-flex;align-items:center;gap:8px;padding:15px 32px;border-radius:var(--r-md);background:var(--cream);color:var(--terra);font-size:15px;font-weight:700;border:none;cursor:pointer;font-family:'Nunito',sans-serif;box-shadow:0 4px 20px rgba(0,0,0,.15);transition:all .25s}
.cta-btn-cream:hover{background:#fff;transform:translateY(-3px);box-shadow:0 8px 32px rgba(0,0,0,.2)}
.cta-btn-ghost{display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border-radius:var(--r-md);background:transparent;color:rgba(255,255,255,.75);border:1.5px solid rgba(255,255,255,.28);font-size:15px;font-weight:500;cursor:pointer;font-family:'Nunito',sans-serif;transition:all .25s}
.cta-btn-ghost:hover{border-color:rgba(255,255,255,.6);color:#fff;background:rgba(255,255,255,.08)}
.cta-btn-cream svg,.cta-btn-ghost svg{width:15px;height:15px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}

/* FOOTER */
footer{background:var(--bark);padding:60px clamp(20px,5vw,72px) 28px}
.footer-top{display:grid;grid-template-columns:2fr 1fr 1fr;gap:48px;padding-bottom:48px;border-bottom:1px solid rgba(255,255,255,.08);margin-bottom:28px}
.footer-logo{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.footer-emblem{width:38px;height:38px;display:flex;align-items:center;justify-content:center}
.footer-emblem img{width:100%;height:100%;object-fit:contain}
.footer-emblem svg{width:16px;height:16px;fill:none;stroke:#fff;stroke-width:2.2;stroke-linecap:round;stroke-linejoin:round}
.footer-brand-name{font-family:'Lora',serif;font-size:20px;font-weight:700;color:#fff;letter-spacing:-.01em;line-height:1}
.footer-brand-name span{color:var(--terra-mid)}
.footer-desc{font-size:.875rem;color:rgba(255,255,255,.38);line-height:1.75;max-width:280px;font-weight:300}
.footer-col h5{font-size:11px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:rgba(255,255,255,.35);margin-bottom:16px;font-family:'Nunito',sans-serif}
.footer-col ul{list-style:none;display:flex;flex-direction:column;gap:10px}
.footer-col a{font-size:.875rem;color:rgba(255,255,255,.45);transition:color .2s}
.footer-col a:hover{color:var(--terra-mid)}
.footer-bottom{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
.footer-copy{font-size:12px;color:rgba(255,255,255,.25)}
.footer-copy a{color:var(--terra-mid)}
.footer-chips{display:flex;gap:8px}
.footer-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;border:1px solid rgba(255,255,255,.1);font-size:10.5px;color:rgba(255,255,255,.3);letter-spacing:.04em}
.footer-chip-dot{width:5px;height:5px;border-radius:50%;background:var(--terra);opacity:.7}

/* RESPONSIVE */
@media(max-width:1100px){.services-grid{grid-template-columns:1fr 1fr}.svc:first-child{grid-column:span 2}}
@media(max-width:900px){.how-inner{grid-template-columns:1fr}.how-left{position:static}.portals-grid{grid-template-columns:1fr}.footer-top{grid-template-columns:1fr 1fr}.footer-brand-col{grid-column:span 2}.trust-strip{flex-direction:column;gap:36px}}
@media(max-width:768px){.nav-links,.nav-right .btn-soft,.nav-right .btn-warm{display:none}.ham-btn{display:flex}.services-grid{grid-template-columns:1fr}.svc:first-child{grid-column:span 1}.hero-stats{flex-direction:column;border-radius:var(--r-lg)}.hero-stat+.hero-stat::before{top:0;left:20%;right:20%;width:auto;height:1px}.footer-top{grid-template-columns:1fr}.footer-brand-col{grid-column:auto}.footer-bottom{flex-direction:column;text-align:center}}
@media(max-width:480px){.hero-ctas{flex-direction:column;width:100%}.hero-ctas .btn-warm,.hero-ctas .btn-soft{width:100%;justify-content:center}.cta-btns{flex-direction:column;width:100%}.cta-btn-cream,.cta-btn-ghost{width:100%;justify-content:center}.trust-metrics{gap:24px}}
</style>
</head>
<body>

<div id="prog"></div>

<nav class="nav" id="nav">
  <a href="{{ route('home') }}" class="nav-logo">
    <div class="nav-emblem">
      <img src="{{ asset('asset/img/logo.svg') }}" alt="MediCal Logo">
    </div>
    <div>
      <div class="nav-brand">Medi<span>Cal</span></div>
      <div class="nav-tagline">Cabinet Médical</div>
    </div>
  </a>
  <ul class="nav-links">
    <li><a href="#services">Services</a></li>
    <li><a href="#how">Processus</a></li>
    <li><a href="#portals">Portails</a></li>
    <li><a href="{{ route('contact') }}">Contact</a></li>
  </ul>
  <div class="nav-right">
    <button class="theme-btn" id="themeBtn"><svg id="themeIcon" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg></button>
    <a href="{{ route('login') }}" class="btn-soft"><svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>Connexion Équipe</a>
    <a href="{{ route('patient.dashboard') }}" class="btn-warm"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Espace Patient</a>
    <button class="ham-btn" id="ham"><span></span><span></span><span></span></button>
  </div>
</nav>

<div class="mob-menu" id="mobMenu">
  <a href="#services">Services</a>
  <a href="#how">Processus</a>
  <a href="#portals">Portails</a>
  <a href="{{ route('contact') }}">Contact</a>
  <div class="mob-cta">
    <a href="{{ route('login') }}" class="btn-soft">Connexion Équipe</a>
    <a href="{{ route('patient.dashboard') }}" class="btn-warm">Mon Espace Patient</a>
  </div>
</div>

<section class="hero" id="hero">
  <div class="hero-blob hero-blob-1"></div>
  <div class="hero-blob hero-blob-2"></div>
  <div class="hero-blob hero-blob-3"></div>
  <div class="hero-arc"></div>
  <div class="hero-arc-2"></div>
  <div class="hero-inner">
    <div class="hero-script">Votre santé, notre priorité</div>
    <h1 class="hero-title">Un cabinet médical<br><em>proche de vous,</em><br>partout.</h1>
    <p class="hero-sub">Prenez vos rendez-vous en ligne, consultez vos ordonnances et accédez à votre dossier médical depuis n'importe où, à tout moment. La médecine avec un cœur humain.</p>
    <div class="hero-ctas">
      <a href="{{ route('register.patient') }}" class="btn-warm"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>Créer mon compte patient</a>
      <a href="#how" class="btn-soft"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>Découvrir comment ça marche</a>
    </div>
    <div class="hero-stats">
      <div class="hero-stat"><div class="hero-stat-val">500+</div><div class="hero-stat-lbl">Patients suivis</div></div>
      <div class="hero-stat"><div class="hero-stat-val">10+</div><div class="hero-stat-lbl">Médecins</div></div>
      <div class="hero-stat"><div class="hero-stat-val">99%</div><div class="hero-stat-lbl">Satisfaction</div></div>
      <div class="hero-stat"><div class="hero-stat-val">24h</div><div class="hero-stat-lbl">Disponible</div></div>
    </div>
  </div>
</section>

<section id="services">
  <div class="services-top reveal">
    <div>
      <div class="eyebrow"><span class="eyebrow-dot"></span>Nos services</div>
      <h2 class="sh2">Tout ce qu'il vous faut,<br><em>en un seul endroit.</em></h2>
    </div>
    <p class="sh-sub" style="align-self:flex-end">Une plateforme complète pour patients et équipe médicale, simple et toujours disponible.</p>
  </div>
  <div class="services-grid">
    <div class="svc reveal" style="transition-delay:.04s">
      <div class="svc-icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/></svg></div>
      <div class="svc-title">Rendez-vous en ligne</div>
      <p class="svc-body">Réservez votre créneau 24h/24, 7j/7. Choisissez votre médecin, la date et l'heure qui vous conviennent le mieux.</p>
      <span class="svc-pill">Disponible 24h/24</span>
    </div>
    <div class="svc reveal" style="transition-delay:.09s">
      <div class="svc-icon"><svg viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div>
      <div class="svc-title">Suivi médical</div>
      <p class="svc-body">Accédez à l'historique complet de vos consultations pour un suivi personnalisé et optimal de votre santé.</p>
      <span class="svc-pill">Suivi personnalisé</span>
    </div>
    <div class="svc reveal" style="transition-delay:.14s">
      <div class="svc-icon"><svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h4"/></svg></div>
      <div class="svc-title">Ordonnances numériques</div>
      <p class="svc-body">Consultez et imprimez vos ordonnances à tout moment. Fini la peur de perdre vos documents médicaux.</p>
      <span class="svc-pill">PDF instantané</span>
    </div>
    <div class="svc reveal" style="transition-delay:.19s">
      <div class="svc-icon"><svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/><path d="M12 11v6M9 14h6"/></svg></div>
      <div class="svc-title">Dossier sécurisé</div>
      <p class="svc-body">Antécédents, allergies, groupe sanguin — toutes vos informations médicales centralisées et protégées.</p>
      <span class="svc-pill">Données protégées</span>
    </div>
  </div>
</section>

<section id="how">
  <div class="how-inner">
    <div class="how-left reveal">
      <div class="eyebrow"><span class="eyebrow-dot"></span>Processus</div>
      <h2 class="sh2">Votre santé en <em>3 étapes</em> simples.</h2>
      <p class="sh-sub" style="margin-bottom:32px">Rejoignez l'espace patient en quelques minutes et profitez de tous nos services médicaux numérisés.</p>
      <div class="how-dots">
        <div class="how-dot active"></div>
        <div class="how-dot"></div>
        <div class="how-dot"></div>
      </div>
    </div>
    <div class="how-steps">
      <div class="step reveal" style="transition-delay:.05s">
        <div class="step-num-wrap"><span class="step-num">1</span></div>
        <div class="step-content">
          <h3 class="step-title">Créez votre compte</h3>
          <p class="step-body">Inscrivez-vous gratuitement. Votre dossier patient est automatiquement créé et sécurisé dès votre inscription.</p>
        </div>
      </div>
      <div class="step reveal" style="transition-delay:.12s">
        <div class="step-num-wrap"><span class="step-num">2</span></div>
        <div class="step-content">
          <h3 class="step-title">Prenez un rendez-vous</h3>
          <p class="step-body">Choisissez votre médecin parmi les disponibilités affichées en temps réel. Confirmation immédiate par email.</p>
        </div>
      </div>
      <div class="step reveal" style="transition-delay:.19s">
        <div class="step-num-wrap"><span class="step-num">3</span></div>
        <div class="step-content">
          <h3 class="step-title">Accédez à vos soins</h3>
          <p class="step-body">Après votre consultation, retrouvez ordonnances, diagnostics et historique directement dans votre espace personnel.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="trust-strip reveal">
  <div class="trust-quote">
    <div class="trust-quote-mark">"</div>
    <p class="trust-quote-text">MediCal a transformé la gestion de mon cabinet. Mes patients adorent pouvoir prendre rendez-vous à n'importe quelle heure.</p>
    <div class="trust-quote-author">Dr. Amina Benali — Médecin généraliste</div>
  </div>
  <div class="trust-metrics">
    <div class="trust-metric"><div class="trust-metric-val">500+</div><div class="trust-metric-lbl">Patients actifs</div></div>
    <div class="trust-metric"><div class="trust-metric-val">10+</div><div class="trust-metric-lbl">Spécialistes</div></div>
    <div class="trust-metric"><div class="trust-metric-val">99%</div><div class="trust-metric-lbl">Satisfaction</div></div>
  </div>
</div>

<section id="portals">
  <div class="portals-header reveal">
    <div class="eyebrow" style="justify-content:center"><span class="eyebrow-dot"></span>Portails d'accès</div>
    <h2 class="sh2">Choisissez votre <em>espace.</em></h2>
    <p class="sh-sub">Deux interfaces pensées pour vous — l'une pour les patients, l'autre pour l'équipe médicale du cabinet.</p>
  </div>
  <div class="portals-grid">
    <div class="portal portal-patient reveal" style="transition-delay:.05s">
      <div class="portal-arc"></div><div class="portal-arc"></div>
      <div class="portal-tag">✦ Espace Patient</div>
      <h3 class="portal-title">Mon espace<br><em>santé.</em></h3>
      <p class="portal-body">Gérez vos rendez-vous, consultez vos ordonnances et accédez à votre dossier médical en toute sécurité, depuis n'importe quel appareil.</p>
      <ul class="portal-list">
        <li>Prise de rendez-vous en ligne</li>
        <li>Consultation des ordonnances</li>
        <li>Accès au dossier médical</li>
        <li>Historique des consultations</li>
      </ul>
      <a href="{{ route('register.patient') }}" class="portal-btn"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>Créer mon compte patient</a>
    </div>
    <div class="portal portal-staff reveal" style="transition-delay:.12s">
      <div class="portal-tag">⚕ Équipe Médicale</div>
      <h3 class="portal-title">Espace de<br><em>gestion.</em></h3>
      <p class="portal-body">Tableau de bord complet pour gérer les patients, planifier les rendez-vous et rédiger les ordonnances en toute simplicité.</p>
      <ul class="portal-list">
        <li>Gestion des rendez-vous et agenda</li>
        <li>Dossiers patients complets</li>
        <li>Création d'ordonnances</li>
        <li>Chat d'équipe intégré</li>
      </ul>
      <a href="{{ route('login') }}" class="portal-btn"><svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>Connexion équipe</a>
    </div>
  </div>
</section>

<section id="cta">
  <div class="cta-card reveal">
    <div class="cta-arc-1"></div><div class="cta-arc-2"></div>
    <div class="cta-script">Commencez dès aujourd'hui</div>
    <h2 class="cta-h">Votre santé mérite<br>le <em>meilleur suivi.</em></h2>
    <p class="cta-p">Rejoignez des centaines de patients qui font confiance à MediCal pour gérer leur santé simplement, chaleureusement et efficacement.</p>
    <div class="cta-btns">
      <a href="{{ route('register.patient') }}" class="cta-btn-cream"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>Créer mon espace patient</a>
      <a href="{{ route('contact') }}" class="cta-btn-ghost"><svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="m2 7 10 7 10-7"/></svg>Nous contacter</a>
    </div>
  </div>
</section>

<footer>
  <div class="footer-top">
    <div class="footer-brand-col">
      <div class="footer-logo">
        <div class="footer-emblem"><img src="{{ asset('asset/img/logo.svg') }}" alt="MediCal Logo"></div>
    <div>
      <div class="footer-brand-name">Medi<span>Cal</span></div>
      <div class="footer-desc" style="font-size:11px; text-transform:uppercase; letter-spacing:0.05em; color:rgba(255,255,255,0.4); margin-top:2px">Cabinet Médical</div>
    </div>
      <p class="footer-desc">Votre plateforme de gestion de cabinet médical. Simplifiez le suivi de votre santé grâce à notre portail numérique sécurisé et chaleureux.</p>
    </div>
    <div class="footer-col">
      <h5>Navigation</h5>
      <ul><li><a href="{{ route('home') }}">Accueil</a></li><li><a href="#services">Services</a></li><li><a href="#how">Processus</a></li><li><a href="{{ route('contact') }}">Contact</a></li></ul>
    </div>
    <div class="footer-col">
      <h5>Portails</h5>
      <ul><li><a href="{{ route('patient.dashboard') }}">Accès Portail Patient</a></li><li><a href="{{ route('register.patient') }}">Créer mon compte</a></li><li><a href="{{ route('login') }}">Connexion Équipe</a></li><li><a href="{{ route('password.request') }}">Mot de passe oublié</a></li></ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p class="footer-copy">© {{ date('Y') }} <a href="{{ route('home') }}">MediCal</a> — Tous droits réservés.</p>
    <div class="footer-chips">
      <span class="footer-chip"><span class="footer-chip-dot"></span>Sécurisé</span>
      <span class="footer-chip"><span class="footer-chip-dot"></span>Confidentiel</span>
      <span class="footer-chip"><span class="footer-chip-dot"></span>RGPD</span>
    </div>
  </div>
</footer>

<script>
const prog=document.getElementById('prog');
window.addEventListener('scroll',()=>{prog.style.transform=`scaleX(${scrollY/(document.documentElement.scrollHeight-innerHeight)})`;},{passive:true});
const nav=document.getElementById('nav');
window.addEventListener('scroll',()=>nav.classList.toggle('solid',scrollY>30),{passive:true});
const tBtn=document.getElementById('themeBtn'),tIcon=document.getElementById('themeIcon');
const sun=`<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>`;
const moon=`<path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>`;
if(localStorage.getItem('mc_t3')==='dark'){document.documentElement.setAttribute('data-theme','dark');tIcon.innerHTML=sun;}
tBtn.addEventListener('click',()=>{const d=document.documentElement.getAttribute('data-theme')==='dark';document.documentElement.setAttribute('data-theme',d?'light':'dark');localStorage.setItem('mc_t3',d?'light':'dark');tIcon.innerHTML=d?moon:sun;});
const ham=document.getElementById('ham'),mob=document.getElementById('mobMenu');
ham.addEventListener('click',()=>{const o=mob.classList.toggle('open');ham.classList.toggle('open',o);document.body.style.overflow=o?'hidden':'';});
mob.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>{mob.classList.remove('open');ham.classList.remove('open');document.body.style.overflow='';}));
const io=new IntersectionObserver(es=>{es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('on');io.unobserve(e.target);}});},{threshold:.1,rootMargin:'0px 0px -28px 0px'});
document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
const dots=document.querySelectorAll('.how-dot'),steps=document.querySelectorAll('.step');
const sObs=new IntersectionObserver(es=>{es.forEach(e=>{if(e.isIntersecting){const i=Array.from(steps).indexOf(e.target);dots.forEach((d,j)=>d.classList.toggle('active',i===j));}});},{threshold:.5});
steps.forEach(s=>sObs.observe(s));
document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',e=>{const t=document.querySelector(a.getAttribute('href'));if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth'});}});});
</script>
</body>
</html>