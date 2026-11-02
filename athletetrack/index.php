<!DOCTYPE html>
<!-- saved from url=(0051)file:///C:/xampp/htdocs/athletetrack/index.php.html -->
<html lang="ms"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="width=device-width,initial-scale=1">
<title>AthleteTrack</title>
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link href="./index_files/css2" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
:root{
  --pri:#E8871E;--pri-d:#BF6E12;--pri-l:#FDF0DF;--pri-l2:#FBDFB8;
  --ink:#0F1B2B;--steel:#1C2E45;--steel-2:#2A4162;
  --bg:#F5F6F8;--surface:#FFFFFF;--border:#E5E7EB;--border-d:#D1D5DB;
  --tx:#0F1B2B;--tx2:#64748B;--tx3:#9CA3AF;
  --gn:#15803D;--gn-l:#DCFCE7;--gn-d:#166534;
  --am:#B45309;--am-l:#FEF3C7;--am-d:#92400E;
  --rd:#DC2626;--rd-l:#FEE2E2;--rd-d:#991B1B;
  --blue:#1D4ED8;--blue-l:#DBEAFE;
  --radius:10px;--radius-sm:7px;--radius-lg:16px;
  --shadow:0 1px 2px rgba(15,27,43,.06);
  --shadow-md:0 1px 0 rgba(15,27,43,.04),0 6px 20px rgba(15,27,43,.07);
  --shadow-lg:0 20px 45px rgba(15,27,43,.16);
  --font-display:'Space Grotesk',sans-serif;
  --font-mono:'IBM Plex Mono',monospace;
}
body{font-family:'Inter',system-ui,-apple-system,'Segoe UI',sans-serif;background:var(--bg);color:var(--tx);font-size:13.5px;line-height:1.5;}
.page{display:none;min-height:100vh;flex-direction:column;}
.page.active{display:flex;}
h1,h2,.logo,.pg-title,.auth-h,.modal-title,.metric-val,.card-title,.stat-tile-val,.profile-name{font-family:var(--font-display);}
.metric-val,.bar-val,.font-mono-num{font-family:var(--font-mono);}

/* ── Topbar ── */
.topbar{display:flex;align-items:center;justify-content:space-between;padding:0 28px;height:56px;background:var(--surface);border-bottom:1px solid var(--border);flex-shrink:0;position:sticky;top:0;z-index:100;}
.logo{display:flex;align-items:center;gap:10px;font-size:15px;font-weight:600;color:var(--tx);}
.logo-mark{width:30px;height:30px;border-radius:7px;background:var(--pri);position:relative;}
.logo-mark::after{content:'';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:16px;height:16px;background:url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='15' cy='4.5' r='2.2'/%3E%3Cpath d='M12.5 8.5l-3 2.2 1 3.3-3 4 1.7 1.3 3.3-4.3-1-2.7 2.3-1.4 2 2.4 3.2-.6-.3-1.9-2.5-.4-1.3-2.6z'/%3E%3C/svg%3E") center/contain no-repeat;}

/* ── Buttons ── */
.btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;font-size:13px;font-weight:500;padding:9px 16px;border-radius:var(--radius-sm);cursor:pointer;border:1.5px solid transparent;font-family:inherit;transition:background .12s,border-color .12s,color .12s;white-space:nowrap;}
.btn-primary{background:var(--pri);color:#fff;border-color:var(--pri);}
.btn-primary:hover{background:var(--pri-d);border-color:var(--pri-d);}
.btn-outline{background:var(--surface);color:var(--tx);border-color:var(--border-d);}
.btn-outline:hover{background:var(--bg);border-color:var(--tx3);}
.btn-danger{background:var(--rd);color:#fff;border-color:var(--rd);}
.btn-dark{background:var(--tx);color:#fff;border-color:var(--tx);}
.btn-ghost{background:transparent;color:var(--tx2);border-color:transparent;}
.btn-ghost:hover{background:var(--bg);}
.btn-sm{padding:6px 12px;font-size:12px;}
.btn-block{width:100%;}
.btn-lg{padding:12px 22px;font-size:14px;}

/* ── Inputs ── */
.fg{margin-bottom:14px;}
.fg label{display:block;font-size:12px;font-weight:500;color:var(--tx2);margin-bottom:5px;}
.fg .req{color:var(--rd);margin-left:2px;}
.inp{width:100%;border:1.5px solid var(--border);background:var(--surface);border-radius:var(--radius-sm);padding:9px 12px;font-size:13.5px;color:var(--tx);font-family:inherit;outline:none;transition:border-color .12s;}
.inp:focus{border-color:var(--pri);}
select.inp{cursor:pointer;}
.inp-with-btn{display:flex;gap:8px;}
.inp-with-btn .inp{flex:1;}

/* ── Cards ── */
.card{background:var(--surface);border-radius:var(--radius);border:1px solid var(--border);box-shadow:var(--shadow);}
.card-body{padding:18px 20px;}
.card-title{font-size:13.5px;font-weight:600;color:var(--tx);margin-bottom:14px;}

/* ── Sidebar ── */
.app-body{display:flex;flex:1;overflow:hidden;}
.sidebar{width:220px;flex-shrink:0;background:linear-gradient(180deg,var(--ink),var(--steel));border-right:1px solid rgba(255,255,255,.06);display:flex;flex-direction:column;}
.sidebar-nav{flex:1;padding:8px 0;}
.nav-item{padding:10px 20px;font-size:13.5px;color:rgba(255,255,255,.62);cursor:pointer;display:flex;align-items:center;gap:10px;border-right:3px solid transparent;transition:background .12s,color .12s;}
.nav-item:hover{background:rgba(255,255,255,.06);color:#fff;}
.nav-item.active{background:rgba(232,135,30,.16);color:var(--pri-l2);font-weight:600;border-right-color:var(--pri);}
.sidebar-user{padding:14px 18px;border-top:1px solid rgba(255,255,255,.08);display:flex;align-items:center;gap:10px;}
.sidebar-user .av{width:32px;height:32px;border-radius:50%;background:var(--pri);color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;font-family:var(--font-mono);}
.sidebar-user b{font-size:13px;color:#fff;display:block;}
.sidebar-user span{font-size:11.5px;color:rgba(255,255,255,.45);}

/* ── Content ── */
.content{flex:1;padding:24px 28px;overflow-y:auto;}
.pg-title{font-size:18px;font-weight:700;color:var(--tx);margin-bottom:2px;}
.pg-sub{font-size:12.5px;color:var(--tx2);margin-bottom:20px;}
.pg-hd{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:18px;}
.pg-hd .left .pg-title{margin-bottom:2px;}
.pg-hd .left .pg-sub{margin-bottom:0;}

/* ── Badges ── */
.badge{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;letter-spacing:.1px;}
.badge-success{background:var(--gn-l);color:var(--gn-d);}
.badge-warning{background:var(--am-l);color:var(--am-d);}
.badge-danger{background:var(--rd-l);color:var(--rd-d);}
.badge-info{background:var(--blue-l);color:var(--blue);}
.badge-default{background:var(--bg);color:var(--tx2);border:1px solid var(--border);}
.badge-primary{background:var(--pri-l);color:var(--pri-d);}

/* ── Table ── */
.tbl-wrap{overflow:hidden;border-radius:var(--radius-lg);border:1px solid var(--border);background:var(--surface);box-shadow:var(--shadow-md);}
table{width:100%;border-collapse:collapse;font-size:13px;}
thead{background:var(--bg);}
th{padding:12px 14px;text-align:left;font-size:10.5px;font-weight:600;color:var(--tx2);letter-spacing:.05em;text-transform:uppercase;border-bottom:1px solid var(--border);}
td{padding:12px 14px;border-bottom:1px solid var(--border);vertical-align:middle;}
tbody tr:last-child td{border-bottom:none;}
tbody tr{transition:background .12s ease;}
tbody tr:hover{background:rgba(232,135,30,.045);}
.ic-btn{width:30px;height:30px;border-radius:6px;border:1px solid var(--border);background:var(--surface);cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:14px;vertical-align:middle;margin-left:4px;transition:background .1s;}
.ic-btn:hover{background:var(--bg);}

/* ── Metrics ── */
.metrics{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;}
.metric{position:relative;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);padding:18px 20px;box-shadow:var(--shadow-md);overflow:hidden;transition:box-shadow .18s ease,transform .18s ease;}
.metric::before{content:"";position:absolute;inset:0 0 auto 0;height:3px;background:linear-gradient(90deg,var(--pri),transparent);}
.metric-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;}
.metric-label{font-size:12px;color:var(--tx2);font-weight:500;}
.metric-ic{width:34px;height:34px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;}
.metric-val{font-size:27px;font-weight:700;color:var(--tx);line-height:1;}
.metric-note{font-size:11.5px;color:var(--tx3);margin-top:4px;}
.card{transition:box-shadow .18s ease;}
.card:hover,.metric:hover{box-shadow:var(--shadow-lg);}

/* ── Auth ── */
.auth-layout{display:flex;flex:1;min-height:calc(100vh - 56px);width:100%;}
.auth-form{flex:1;padding:48px 52px;display:flex;flex-direction:column;justify-content:center;}
.auth-panel{width:380px;flex-shrink:0;background:var(--pri);color:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:40px;text-align:center;}
.auth-panel-ic{width:60px;height:60px;border-radius:14px;background:rgba(255,255,255,.18);margin:0 auto 20px;display:flex;align-items:center;justify-content:center;}
.auth-panel-ic::after{content:'';width:32px;height:32px;background:url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='15' cy='4.5' r='2.2'/%3E%3Cpath d='M12.5 8.5l-3 2.2 1 3.3-3 4 1.7 1.3 3.3-4.3-1-2.7 2.3-1.4 2 2.4 3.2-.6-.3-1.9-2.5-.4-1.3-2.6z'/%3E%3C/svg%3E") center/contain no-repeat;display:block;}
.auth-panel h2{font-size:22px;font-weight:700;margin-bottom:8px;}
.auth-panel p{font-size:13px;opacity:.85;line-height:1.65;}
.auth-h{font-size:20px;font-weight:700;margin-bottom:4px;}
.auth-sub{font-size:13px;color:var(--tx2);margin-bottom:24px;}
.back-link{display:inline-flex;align-items:center;gap:5px;font-size:13px;color:var(--tx2);cursor:pointer;margin-bottom:20px;}
.back-link:hover{color:var(--pri);}

/* ── Segment ── */
.seg{display:flex;background:var(--bg);border:1.5px solid var(--border);border-radius:var(--radius-sm);padding:3px;gap:3px;margin-bottom:18px;}
.seg-btn{flex:1;text-align:center;padding:8px;border-radius:5px;cursor:pointer;font-size:13px;font-weight:500;color:var(--tx2);transition:.12s;}
.seg-btn.on{background:var(--surface);color:var(--pri-d);box-shadow:0 1px 3px rgba(0,0,0,.1);}

/* ── Steps ── */
.steps{display:flex;align-items:center;margin-bottom:24px;}
.step-wrap{display:flex;align-items:center;flex:1;}
.step-wrap:last-child{flex:none;}
.step-dot{width:26px;height:26px;border-radius:50%;border:2px solid var(--border);background:var(--surface);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;color:var(--tx3);flex-shrink:0;}
.step-dot.done{background:var(--pri);border-color:var(--pri);color:#fff;}
.step-dot.active{border-color:var(--pri);color:var(--pri);}
.step-lbl{font-size:11px;color:var(--tx3);margin-top:4px;text-align:center;}
.step-inner{display:flex;flex-direction:column;align-items:center;}
.step-line{flex:1;height:2px;background:var(--border);margin:0 4px;margin-bottom:18px;}
.step-line.done{background:var(--pri);}

/* ── Invoice ── */
.inv-card{border:1px solid var(--border);border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-md);}
.inv-head{background:linear-gradient(135deg,var(--ink),var(--steel-2));padding:16px 18px;display:flex;justify-content:space-between;align-items:center;color:#fff;}
.inv-head .no{font-size:11px;opacity:.65;margin-bottom:3px;font-family:var(--font-mono);letter-spacing:.03em;}
.inv-head .num{font-size:15px;font-weight:700;font-family:var(--font-mono);color:var(--pri-l2);}
.inv-row{display:flex;justify-content:space-between;align-items:center;padding:10px 18px;border-bottom:1px solid var(--border);}
.inv-row:last-child{border-bottom:none;}
.inv-row .k{font-size:13px;color:var(--tx2);}
.inv-row .v{font-size:13px;font-weight:500;}
.inv-total{display:flex;justify-content:space-between;align-items:center;padding:14px 18px;background:var(--pri-l);border-top:1px solid var(--pri-l2);}
.inv-total .tl{font-size:12.5px;color:var(--tx2);}
.inv-total .tv{font-size:22px;font-weight:700;color:var(--pri-d);font-family:var(--font-display);}

/* ── Upload Zone ── */
.upload-zone{border:2px dashed var(--pri-l2);border-radius:var(--radius);padding:24px;text-align:center;background:var(--pri-l);cursor:pointer;}
.upload-zone:hover{border-color:var(--pri);}
.upload-zone .icon{font-size:24px;margin-bottom:6px;}
.upload-zone p{font-size:13px;font-weight:500;color:var(--pri-d);}
.upload-zone small{font-size:12px;color:var(--tx3);}

/* ── Profile ── */
.profile-hd{display:flex;align-items:center;gap:18px;padding-bottom:20px;border-bottom:1px solid var(--border);margin-bottom:20px;}
.profile-av{width:68px;height:68px;border-radius:50%;background:var(--pri-l);color:var(--pri-d);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;}
.profile-name{font-size:18px;font-weight:700;}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:0;}
.info-row{display:flex;flex-direction:column;padding:12px 0;border-bottom:1px solid var(--border);}
.info-row:nth-child(odd){padding-right:24px;}
.info-row:nth-child(even){padding-left:24px;border-left:1px solid var(--border);}
.info-label{font-size:11.5px;color:var(--tx3);font-weight:500;text-transform:uppercase;letter-spacing:.3px;margin-bottom:4px;}
.info-val{font-size:13.5px;color:var(--tx);font-weight:500;}

/* ── Pakej Cards ── */
.pkg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
.pkg-card{border:1.5px solid var(--border);border-radius:var(--radius);overflow:hidden;background:var(--surface);}
.pkg-card.mine{border-color:var(--pri);}
.pkg-banner{aspect-ratio:1131/1600;display:flex;align-items:center;justify-content:center;padding:16px;text-align:center;background-color:var(--ink);}
.pkg-banner p{font-size:13px;font-weight:700;color:#fff;line-height:1.4;}
.pkg-info{padding:16px;}
.pkg-name{font-size:14px;font-weight:600;margin-bottom:3px;}
.pkg-detail{font-size:12px;color:var(--tx2);margin-bottom:10px;}
.pkg-price{font-size:18px;font-weight:700;color:var(--pri);}
.pkg-price small{font-size:12px;font-weight:400;color:var(--tx2);}

/* ── Chart (CSS bars) ── */
.bar-chart{display:flex;align-items:flex-end;gap:10px;height:130px;padding:8px 4px 0;border-bottom:1px solid var(--border);}
.bar-col{flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;}
.bar-col .bar{width:100%;max-width:38px;background:linear-gradient(180deg,var(--pri),var(--pri-d));border-radius:6px 6px 0 0;transition:opacity .15s ease,transform .15s ease;}
.bar-col:hover .bar{opacity:.85;transform:scaleY(1.01);}
.bar-col .bar-lbl{font-size:10.5px;color:var(--tx3);text-align:center;line-height:1.4;}
.bar-col .bar-val{font-size:10.5px;color:var(--tx);font-weight:600;}

/* ── Diverging Bar Chart (Acara vs % Perubahan) ── */
.bar-chart-diverge{display:flex;gap:14px;padding:4px 4px 0;}
.bdc-col{flex:1;display:flex;flex-direction:column;align-items:center;min-width:0;}
.bdc-top{height:80px;width:100%;display:flex;flex-direction:column;align-items:center;justify-content:flex-end;}
.bdc-mid{width:100%;height:1px;background:var(--border-d);flex-shrink:0;}
.bdc-bottom{height:80px;width:100%;display:flex;flex-direction:column;align-items:center;justify-content:flex-start;}
.bdc-bar{width:60%;max-width:34px;border-radius:5px;transition:opacity .15s ease;}
.bdc-col:hover .bdc-bar{opacity:.85;}
.bdc-val{font-size:10.5px;font-weight:700;white-space:nowrap;}
.bdc-top .bdc-val{margin-bottom:4px;}
.bdc-bottom .bdc-val{margin-top:4px;}
.bdc-lbl{font-size:10.5px;color:var(--tx3);text-align:center;line-height:1.35;margin-top:8px;}

/* ── Progress Bar ── */
.prog-wrap{height:6px;background:var(--border);border-radius:6px;overflow:hidden;margin:6px 0;}
.prog{height:100%;border-radius:6px;background:var(--gn);transition:width .3s ease;}
.prog.warn{background:var(--am);}
.prog.danger{background:var(--rd);}

/* ── Tick ── */
.tick{width:30px;height:30px;border-radius:7px;border:1.5px solid var(--border);background:var(--surface);cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;transition:.12s;}
.tick.hadir{background:var(--gn);border-color:var(--gn);color:#fff;}
.tick.tidak{background:var(--rd);border-color:var(--rd);color:#fff;}
.tick2{width:27px;height:27px;border-radius:50%;border:none;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#fff;transition:.12s;margin:0 3px;opacity:.3;}
.tick2:hover{opacity:.65;}
.tick2.on{opacity:1;}
.tick2.on:hover{opacity:1;}
.tick2.hadir-btn{background:var(--gn);}
.tick2.tidak-btn{background:var(--rd);}

/* ── Modal ── */
.modal-bg{position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:500;display:none;align-items:center;justify-content:center;padding:20px;}
.modal-bg.open{display:flex;}
.modal{background:var(--surface);border-radius:var(--radius-lg);width:100%;max-width:480px;box-shadow:var(--shadow-lg);max-height:90vh;display:flex;flex-direction:column;}
.modal-hd{padding:20px 22px 16px;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;justify-content:space-between;flex-shrink:0;}
.modal-title{font-size:15px;font-weight:700;}
.modal-sub{font-size:12px;color:var(--tx2);margin-top:2px;}
.modal-close{background:none;border:none;font-size:18px;cursor:pointer;color:var(--tx3);padding:0 0 0 10px;line-height:1;}
.modal-close:hover{color:var(--tx);}
.modal-body{padding:20px 22px;overflow-y:auto;flex:1;}
.modal-ft{padding:14px 22px;border-top:1px solid var(--border);display:flex;gap:10px;justify-content:flex-end;flex-shrink:0;}

/* ── Grid ── */
.g2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;}
.gap-row{display:flex;gap:10px;align-items:center;flex-wrap:wrap;}

/* ── Misc ── */
.divider{border:0;border-top:1px solid var(--border);margin:16px 0;}
.notif-bar{background:var(--am-l);border:1px solid #FDE68A;border-radius:var(--radius-sm);padding:10px 14px;font-size:12.5px;color:var(--am-d);margin-bottom:16px;}
.search-row{display:flex;gap:10px;align-items:center;margin-bottom:16px;}
.search-row .inp{max-width:220px;}
.empty{text-align:center;padding:40px;color:var(--tx3);}
a.link{color:var(--pri);cursor:pointer;text-decoration:underline;}

/* ── Toast ── */
#toast{position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(30px);background:var(--tx);color:#fff;padding:12px 20px;border-radius:var(--radius);font-size:13px;font-weight:500;opacity:0;transition:.25s;pointer-events:none;z-index:9999;box-shadow:var(--shadow-lg);}
#toast.show{opacity:1;transform:translateX(-50%) translateY(0);}

/* ── Landing Hero ── */
.hero{background:linear-gradient(160deg,#0f1e14 0%,#1a3a1e 40%,#2d1a0a 100%);min-height:340px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;}
.hero-content{position:relative;text-align:center;color:#fff;padding:40px 20px;}
.hero-tag{display:inline-block;background:rgba(234,106,26,.3);border:1px solid rgba(234,106,26,.5);border-radius:20px;padding:4px 14px;font-size:12px;font-weight:500;margin-bottom:16px;}
.hero h1{font-size:36px;font-weight:800;margin-bottom:10px;letter-spacing:-.5px;}
.hero p{font-size:14px;opacity:.8;margin-bottom:24px;}
.hero-btns{display:flex;gap:10px;justify-content:center;}
.hero-btn-pri{background:var(--pri);color:#fff;border:none;padding:12px 24px;border-radius:var(--radius-sm);font-size:14px;font-weight:600;cursor:pointer;}
.hero-btn-sec{background:transparent;color:#fff;border:1.5px solid rgba(255,255,255,.4);padding:12px 24px;border-radius:var(--radius-sm);font-size:14px;font-weight:600;cursor:pointer;}
.landing-section{padding:32px 40px;}
.section-title{font-size:16px;font-weight:700;margin-bottom:6px;}
.section-sub{font-size:13px;color:var(--tx2);margin-bottom:20px;}
.feat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;}
.feat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px;}
.feat-icon{width:38px;height:38px;border-radius:9px;background:var(--pri-l);color:var(--pri-d);display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:12px;}
.feat-title{font-size:13.5px;font-weight:600;margin-bottom:4px;}
.feat-desc{font-size:12.5px;color:var(--tx2);line-height:1.55;}
.footer{background:var(--tx);color:#9CA3AF;padding:20px 40px;font-size:12px;display:flex;justify-content:center;align-items:center;margin-top:auto;}

/* ── Global polish ── */
button{transition:background-color .12s ease,border-color .12s ease,color .12s ease,transform .1s ease,box-shadow .12s ease;}
.btn:active,.ic-btn:active{transform:translateY(1px);}
.btn-primary{box-shadow:0 1px 2px rgba(232,135,30,.35);}
.pkg-card{transition:box-shadow .18s ease,transform .18s ease;}
.pkg-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-2px);}
::-webkit-scrollbar{width:8px;height:8px;}
::-webkit-scrollbar-thumb{background:#c7ccd4;border-radius:8px;}
.fg.locked label{color:var(--tx3);}
.fg.locked .inp{background:var(--bg);color:var(--tx2);cursor:not-allowed;border-color:var(--border);}
.fg.locked small{display:block;margin-top:5px;font-size:11px;color:var(--tx3);}

/* ── Report Preview / Print ── */
.report-modal-card{background:var(--surface);border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-lg);max-width:720px;width:100%;max-height:92vh;display:flex;flex-direction:column;}
.report-banner{background:linear-gradient(135deg,var(--ink),var(--steel));color:#fff;padding:14px 22px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-shrink:0;}
.report-banner span{font-family:var(--font-mono);font-size:11px;letter-spacing:.05em;color:rgba(255,255,255,.65);}
.report-close{background:rgba(255,255,255,.12);border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:12px;line-height:1;}
.report-close:hover{background:rgba(255,255,255,.22);}
.report-body{padding:28px 32px;overflow-y:auto;}
.report-letterhead{text-align:center;margin-bottom:14px;}
.report-letterhead h3{font-family:var(--font-display);font-size:15px;font-weight:700;letter-spacing:.02em;}
.report-letterhead p{font-size:11px;color:var(--tx2);margin-top:2px;}
.report-title{text-align:center;font-weight:700;font-size:14.5px;margin-bottom:2px;}
.report-sub{text-align:center;font-size:12px;color:var(--tx2);margin-bottom:14px;}
.report-meta{display:flex;justify-content:space-between;font-size:10.5px;color:var(--tx3);font-family:var(--font-mono);margin-bottom:14px;}
.report-ft{padding:14px 22px;border-top:1px solid var(--border);display:flex;gap:10px;flex-shrink:0;}
@media print{
  body *{visibility:hidden;}
  #reportPrintArea,#reportPrintArea *{visibility:visible;}
  #reportPrintArea{position:absolute;left:0;top:0;width:100%;padding:0;}
  .no-print{display:none !important;}
}
</style>
</head>
<body>
<div id="toast"></div>
<div class="page active" id="p-landing">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><div style="display:flex;gap:8px;"><button class="btn btn-outline btn-sm" onclick="go(&#39;p-daftar&#39;)">Daftar</button><button class="btn btn-primary btn-sm" onclick="go(&#39;p-login&#39;)">Log Masuk</button></div></div>
<div class="hero" style="background-image:linear-gradient(180deg,rgba(0,0,0,.35) 0%,rgba(0,0,0,.55) 100%),url(&#39;stadium.jpeg&#39;);background-size:cover;background-position:center;">
      <div class="hero-content">
        <div class="hero-tag">Kompleks Belia &amp; Sukan Selangor, Shah Alam</div>
        <h1>Kelab Olahraga Shah Alam</h1>
        <p>Platform pengurusan atlet yang bersepadu.</p>
        <div class="hero-btns">
          <button class="hero-btn-pri" onclick="go(&#39;p-daftar&#39;)">Daftar Sekarang</button>
          <button class="hero-btn-sec" onclick="go(&#39;p-login&#39;)">Log Masuk</button>
        </div>
      </div>
    </div>
    <div class="landing-section">
      <div class="section-title">Pelbagai pilihan pakej yang menarik!</div>
      <div class="section-sub">Yuran bulanan termasuk bimbingan jurulatih bertauliah. Baju-T RM25.00 (bayaran sekali sahaja).</div>
      <div class="pkg-grid" id="landing-pakej">
        <div class="pkg-card" onclick="go(&#39;p-login&#39;)">
          <div class="pkg-banner" style="background-image:url(&#39;weekday package.jfif&#39;);background-size:contain;background-repeat:no-repeat;background-position:center;"></div>
          <div class="pkg-info">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
              <span class="pkg-name">Pakej Hari Biasa</span>
            </div>
            <div class="pkg-detail">Isnin &amp; Khamis · Pilih 1 sesi: 5.00–6.15ptg atau 8.00–9.15mlm · Track &amp; Field (Larian Pecut &amp; Latihan Asas Olahraga)</div>
            <div class="pkg-price">RM180<small>/bulan</small></div>
          </div>
        </div>
        <div class="pkg-card" onclick="go(&#39;p-login&#39;)">
          <div class="pkg-banner" style="background-image:url(&#39;weekend package.jfif&#39;);background-size:contain;background-repeat:no-repeat;background-position:center;"></div>
          <div class="pkg-info">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
              <span class="pkg-name">Pakej Hari Sabtu</span>
            </div>
            <div class="pkg-detail">Sabtu · Petang (5.00–6.30ptg) · Track &amp; Field (Larian Pecut &amp; Latihan Asas Olahraga)</div>
            <div class="pkg-price">RM160<small>/bulan</small></div>
          </div>
        </div>
        <div class="pkg-card" onclick="go(&#39;p-login&#39;)">
          <div class="pkg-banner" style="background-image:url(&#39;high jump.jfif&#39;);background-size:contain;background-repeat:no-repeat;background-position:center;"></div>
          <div class="pkg-info">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
              <span class="pkg-name">Pakej Lompat Tinggi</span>
            </div>
            <div class="pkg-detail">Sabtu · Petang (5.00–6.30ptg)</div>
            <div class="pkg-price">RM160<small>/bulan</small></div>
          </div>
        </div>
        <div class="pkg-card" onclick="go(&#39;p-login&#39;)">
          <div class="pkg-banner" style="background-image:url(&#39;lontar peluru.jfif&#39;);background-size:contain;background-repeat:no-repeat;background-position:center;"></div>
          <div class="pkg-info">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
              <span class="pkg-name">Pakej Latihan Lontaran</span>
            </div>
            <div class="pkg-detail">Isnin · Malam (8.00–9.00mlm) · Javelin, Shot Put, Discus</div>
            <div class="pkg-price">RM160<small>/bulan</small></div>
          </div>
        </div>
        <div class="pkg-card" onclick="go(&#39;p-login&#39;)">
          <div class="pkg-banner" style="background-image:url(&#39;mid long distance.jfif&#39;);background-size:contain;background-repeat:no-repeat;background-position:center;"></div>
          <div class="pkg-info">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
              <span class="pkg-name">Pakej Larian Jarak Jauh (Dewasa)</span>
            </div>
            <div class="pkg-detail">Isnin &amp; Khamis · Malam (8.00–9.15mlm) · Dewasa, tiada had umur</div>
            <div class="pkg-price">RM180<small>/bulan</small></div>
          </div>
        </div>
        <div class="pkg-card" onclick="go(&#39;p-login&#39;)">
          <div class="pkg-banner" style="background-image:url(&#39;mid long distance (9-18).jfif&#39;);background-size:contain;background-repeat:no-repeat;background-position:center;"></div>
          <div class="pkg-info">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;">
              <span class="pkg-name">Pakej Larian Jarak Jauh (9-18 Tahun)</span>
            </div>
            <div class="pkg-detail">Isnin &amp; Khamis · Malam (8.00–9.15mlm) · Kanak-kanak &amp; belia 9-18 tahun</div>
            <div class="pkg-price">RM180<small>/bulan</small></div>
          </div>
        </div></div>
    </div>
    <div class="footer">
      <span>© Kelab Olahraga Shah Alam</span>
    </div></div>
<div class="page" id="p-login">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="go(&#39;p-daftar&#39;)">Daftar</button></div>
    <div class="auth-layout">
      <div class="auth-form">
        <span class="back-link" onclick="logoutAction()">← Kembali</span>
        <div class="auth-h">Log Masuk</div>
        <div class="seg">
          <div class="seg-btn on" id="seg-atlet" onclick="setSeg(&#39;atlet&#39;)">Atlet</div>
          <div class="seg-btn" id="seg-admin" onclick="setSeg(&#39;admin&#39;)">Admin</div>
        </div>
        <div class="fg"><label>No. Kad Pengenalan<span class="req">*</span></label><input class="inp" id="login-kp" type="text" placeholder="Contoh: 010101-01-0101"></div>
        <div class="fg"><label>Kata Laluan<span class="req">*</span></label><input class="inp" id="login-pass" type="password" placeholder="Masukkan kata laluan"></div>
        <div style="text-align:right;margin-bottom:18px;"><a class="link" style="font-size:12.5px;" onclick="go(&#39;p-lupa&#39;)">Lupa kata laluan?</a></div>
        <button class="btn btn-dark btn-block btn-lg" onclick="loginAction()">Log Masuk</button>
      </div>
      <div class="auth-panel">
        <div class="auth-panel-ic"></div>
        <h2>Selamat Kembali!</h2>
        <p>Sistem Pengurusan<br>Kelab Olahraga Shah Alam</p>
      </div>
    </div></div>
<div class="page" id="p-lupa">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="go(&#39;p-daftar&#39;)">Daftar</button></div>
    <div class="auth-layout">
      <div class="auth-form">
        <span class="back-link" onclick="go(&#39;p-login&#39;)">← Kembali ke Log Masuk</span>
        <div class="auth-h">Lupa Kata Laluan?</div>
        <div class="fg"><label>Alamat E-mel<span class="req">*</span></label><input class="inp" id="lupa-email" type="email" placeholder="nama@emel.com"></div>
        <button class="btn btn-dark btn-block btn-lg" onclick="lupaKataLaluan()">Hantar Pautan Reset</button>
        <p style="font-size:12px;color:var(--tx3);text-align:center;margin-top:12px;">Semak folder <em>spam</em> jika tiada e-mel dalam 5 minit.</p>
      </div>
      <div class="auth-panel">
        <div class="auth-panel-ic"></div>
        <h2>Selamat Kembali!</h2>
        <p>Sistem Pengurusan<br>Kelab Olahraga Shah Alam</p>
      </div>
    </div></div>
<div class="page" id="p-daftar">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="go(&#39;p-login&#39;)">Log Masuk</button></div>
    <div class="auth-layout">
      <div class="auth-form">
        <span class="back-link" onclick="logoutAction()">← Kembali</span>
        <div class="steps"><div class="step-inner"><div class="step-dot active">1</div><div class="step-lbl">Akaun</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">2</div><div class="step-lbl">Maklumat</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">3</div><div class="step-lbl">Persetujuan</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">4</div><div class="step-lbl">Invois</div></div></div>
        <div class="auth-h">Daftar Akaun</div>
        <div class="fg"><label>Alamat E-mel<span class="req">*</span></label><input class="inp" id="daftar-email" type="email" placeholder="nama@emel.com"></div>
        <div class="fg"><label>Cipta kata laluan<span class="req">*</span></label><input class="inp" id="daftar-pass" type="password" placeholder="Sekurang-kurangnya 8 aksara"></div>
        <div class="fg"><label>Sahkan kata laluan<span class="req">*</span></label><input class="inp" id="daftar-pass-sahkan" type="password" placeholder="Masukkan semula kata laluan"></div>
        <button class="btn btn-dark btn-block btn-lg" onclick="semakLangkahDaftar(&#39;akaun&#39;)">Seterusnya</button>
      </div>
      <div class="auth-panel">
        <div class="auth-panel-ic"></div>
        <h2>Selamat Datang!</h2>
        <p>Sistem Pengurusan<br>Kelab Olahraga Shah Alam</p>
      </div>
    </div></div>
<div class="page" id="p-daftar2">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="go(&#39;p-login&#39;)">Log Masuk</button></div>
    <div class="auth-layout">
      <div class="auth-form">
        <span class="back-link" onclick="go(&#39;p-daftar&#39;)">← Kembali</span>
        <div class="steps"><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Akaun</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot active">2</div><div class="step-lbl">Maklumat</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">3</div><div class="step-lbl">Persetujuan</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">4</div><div class="step-lbl">Invois</div></div></div>
        <div class="auth-h">Maklumat Atlet</div>
        <div class="fg"><label>Pilih pakej<span class="req">*</span></label><select class="inp" id="daftarPakej"><option value="">-- Pilih pakej --</option><option value="Hari Biasa">Pakej Hari Biasa (Track &amp; Field, Isnin &amp; Khamis) — RM180/bln</option><option value="Hari Sabtu">Pakej Hari Sabtu (Track &amp; Field, Sabtu) — RM160/bln</option><option value="Lompat Tinggi">Pakej Lompat Tinggi (Sabtu) — RM160/bln</option><option value="Latihan Lontaran">Pakej Latihan Lontaran (Isnin) — RM160/bln</option><option value="Larian Jarak Jauh (Dewasa)">Pakej Larian Jarak Jauh (Dewasa) (Isnin &amp; Khamis) — RM180/bln</option><option value="Larian Jarak Jauh (9-18 Tahun)">Pakej Larian Jarak Jauh (9-18 Tahun) (Isnin &amp; Khamis) — RM180/bln</option></select></div>
        <div class="fg"><label>Nama penuh<span class="req">*</span></label><input class="inp" id="daftar-nama" type="text" placeholder="Seperti dalam kad pengenalan"></div>
        <div class="fg"><label>No. kad pengenalan<span class="req">*</span></label><input class="inp" id="daftar-kp" type="text" placeholder="Contoh: 010101-01-0101"></div>
        <div class="fg"><label>Tarikh lahir<span class="req">*</span></label><input class="inp" id="daftar-tarikhlahir" type="date" placeholder=""></div>
        <button class="btn btn-dark btn-block btn-lg" onclick="semakLangkahDaftar(&#39;atlet&#39;)">Seterusnya</button>
      </div>
      <div class="auth-panel">
        <div class="auth-panel-ic"></div>
        <h2>Selamat Datang!</h2>
        <p>Sistem Pengurusan<br>Kelab Olahraga Shah Alam</p>
      </div>
    </div></div>
<div class="page" id="p-daftar3">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="go(&#39;p-login&#39;)">Log Masuk</button></div>
    <div class="auth-layout">
      <div class="auth-form">
        <span class="back-link" onclick="go(&#39;p-daftar2&#39;)">← Kembali</span>
        <div class="steps"><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Akaun</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot active">2</div><div class="step-lbl">Maklumat</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">3</div><div class="step-lbl">Persetujuan</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">4</div><div class="step-lbl">Invois</div></div></div>
        <div class="auth-h">Maklumat Waris</div>
        <div class="fg"><label>Nama ibu/bapa/penjaga<span class="req">*</span></label><input class="inp" id="daftar-namapenjaga" type="text" placeholder="Nama penuh"></div>
        <div class="fg"><label>No. telefon ibu/bapa/penjaga<span class="req">*</span></label><input class="inp" id="daftar-telpenjaga" type="tel" placeholder="Contoh: 012-3456789"></div>
        <div class="fg"><label>Alamat e-mel ibu/bapa/penjaga<span class="req">*</span></label><input class="inp" id="daftar-emelpenjaga" type="email" placeholder="emel@contoh.com"></div>
        <div class="fg"><label>Nama sekolah/institusi</label><input class="inp" id="daftar-sekolah" type="text" placeholder="Nama sekolah (jika bersekolah)"></div>
        <div class="fg"><label>Sesi latihan<span class="req">*</span></label><select class="inp" id="daftarSesi"><option>-- Pilih sesi --</option></select></div>
        <button class="btn btn-dark btn-block btn-lg" onclick="semakLangkahDaftar(&#39;waris&#39;)">Seterusnya</button>
      </div>
      <div class="auth-panel">
        <div class="auth-panel-ic"></div>
        <h2>Selamat Datang!</h2>
        <p>Sistem Pengurusan<br>Kelab Olahraga Shah Alam</p>
      </div>
    </div></div>
<div class="page" id="p-bersetuju">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="go(&#39;p-login&#39;)">Log Masuk</button></div>
    <div class="auth-layout">
      <div class="auth-form">
        <span class="back-link" onclick="go(&#39;p-daftar3&#39;)">← Kembali</span>
        <div class="steps"><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Akaun</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Maklumat</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot active">3</div><div class="step-lbl">Persetujuan</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">4</div><div class="step-lbl">Invois</div></div></div>
        <div class="auth-h">Persetujuan Penyertaan</div>
        <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px;margin-bottom:20px;font-size:13px;line-height:1.7;">
          <p><strong>Saya BERSETUJU</strong> untuk mengambil bahagian dalam program ini.<br>
          <em style="font-size:12px;color:var(--tx2);">I AGREE to take part in this programme.</em></p>
        </div>
        <div style="display:flex;flex-direction:column;gap:12px;margin-bottom:24px;">
          <label style="display:flex;align-items:center;gap:12px;cursor:pointer;font-size:13.5px;" onclick="pilihPersetujuan(true)">
            <div class="radio-item on" id="r-agree">
              <div class="radio-bulat" style="width:18px;height:18px;border-radius:50%;border:2px solid var(--pri);background:var(--pri);display:flex;align-items:center;justify-content:center;">
                <div style="width:7px;height:7px;border-radius:50%;background:#fff;"></div>
              </div>
            </div>
            Bersetuju (Agree)
          </label>
          <label style="display:flex;align-items:center;gap:12px;cursor:pointer;font-size:13.5px;" onclick="pilihPersetujuan(false)">
            <div class="radio-item" id="r-disagree">
              <div class="radio-bulat" style="width:18px;height:18px;border-radius:50%;border:2px solid var(--border-d);background:var(--surface);display:flex;align-items:center;justify-content:center;">
                <div style="width:7px;height:7px;border-radius:50%;background:#fff;"></div>
              </div>
            </div>
            Tidak Bersetuju (Disagree)
          </label>
        </div>
        <button class="btn btn-dark btn-block btn-lg" onclick="teruskanPersetujuan()">Teruskan</button>
      </div>
      <div class="auth-panel">
        <div class="auth-panel-ic"></div>
        <h2>Selamat Datang!</h2>
        <p>Sistem Pengurusan<br>Kelab Olahraga Shah Alam</p>
      </div>
    </div></div>
<div class="page" id="p-deklarasi">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="go(&#39;p-login&#39;)">Log Masuk</button></div>
    <div class="auth-layout">
      <div class="auth-form">
        <span class="back-link" onclick="go(&#39;p-bersetuju&#39;)">← Kembali</span>
        <div class="steps"><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Akaun</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Maklumat</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot active">3</div><div class="step-lbl">Persetujuan</div></div><div class="step-line "></div><div class="step-inner"><div class="step-dot ">4</div><div class="step-lbl">Invois</div></div></div>
        <div class="auth-h">Pengakuan dan Deklarasi</div>
        <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px;font-size:13px;line-height:1.75;margin-bottom:20px;">
          <p style="margin-bottom:10px;"><strong>1.</strong> Saya mengaku semua maklumat di atas adalah benar.<br>
          <em style="font-size:12px;color:var(--tx2);">I acknowledge all the information given above is true.</em></p>
          <p><strong>2.</strong> Saya dan peserta bersetuju mematuhi semua peraturan dan syarat yang ditetapkan oleh penganjur program SHAH ALAM TRACK AND FIELD ACADEMY.<br>
          <em style="font-size:12px;color:var(--tx2);">The participant and I agree to abide to all the rules set by the organiser.</em></p>
        </div>
        <label style="display:flex;align-items:center;gap:10px;cursor:pointer;font-size:13px;margin-bottom:24px;padding:12px;background:var(--pri-l);border-radius:var(--radius-sm);border:1px solid var(--pri-l2);">
          <input type="checkbox" id="deklarasi-setuju" style="width:16px;height:16px;accent-color:var(--pri);">
          <span>Saya Setuju dengan terma dan syarat di atas.</span>
        </label>
        <button class="btn btn-dark btn-block btn-lg" onclick="daftarAction()">Teruskan</button>
      </div>
      <div class="auth-panel">
        <div class="auth-panel-ic"></div>
        <h2>Selamat Datang!</h2>
        <p>Sistem Pengurusan<br>Kelab Olahraga Shah Alam</p>
      </div>
    </div></div>
<div class="page" id="p-invois">
    <div class="topbar"><div class="logo" onclick="logoutAction()" style="cursor:pointer;"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="go(&#39;p-login&#39;)">Log Masuk</button></div>
    <div class="auth-layout">
      <div class="auth-form">
        <span class="back-link" onclick="go(&#39;p-deklarasi&#39;)">← Kembali</span>
        <div class="steps"><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Akaun</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Maklumat</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot done">✓</div><div class="step-lbl">Persetujuan</div></div><div class="step-line done"></div><div class="step-inner"><div class="step-dot active">4</div><div class="step-lbl">Invois</div></div></div>
        <div class="auth-h">Invois Anda</div>
        <div class="inv-card" style="margin-bottom:16px;">
          <div class="inv-head">
            <div><div class="no">No. Invois</div><div class="num" id="daftar-inv-no">-</div></div>
            <span class="badge badge-warning">Belum Bayar</span>
          </div>
          <div class="inv-row"><span class="k">Nama atlet</span><span class="v" id="daftar-inv-nama">-</span></div>
          <div class="inv-row"><span class="k">Pakej dipilih</span><span class="v" id="daftar-inv-pakej">-</span></div>
          <div class="inv-row"><span class="k">Baju-T (sekali sahaja)</span><span class="v" id="daftar-inv-baju">-</span></div>
          <div class="inv-row"><span class="k">Yuran bulanan</span><span class="v" id="daftar-inv-yuran">-</span></div>
          <div class="inv-row"><span class="k">Tarikh akhir bayar</span><span class="v" style="color:var(--rd);font-weight:600;" id="daftar-inv-tarikh">-</span></div>
          <div class="inv-total"><span class="tl">Jumlah perlu dibayar</span><span class="tv" id="daftar-inv-jumlah">-</span></div>
        </div>
        <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 14px;margin-bottom:16px;font-size:12.5px;">
          <strong>Maklumat Pembayaran:</strong> Maybank &nbsp;5621-0685-7064 &nbsp;(Shah Alam Athletics)<br>
          <span style="color:var(--tx2);">Selepas bayar, muat naik bukti pembayaran di bawah.</span>
        </div>
        <input type="file" id="daftar-bukti-input" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf" style="display:none;" onchange="hantarBuktiPendaftaran(this)">
        <div class="upload-zone" style="margin-bottom:12px;" onclick="document.getElementById(&#39;daftar-bukti-input&#39;).click()">
          <div class="icon">📁</div>
          <p>Klik untuk muat naik bukti pembayaran</p>
          <small>JPG, PNG atau PDF · maks 5MB</small>
        </div>
        <p style="font-size:11.5px;color:var(--tx3);margin-top:10px;text-align:center;">* Pembayaran pertama <strong>wajib diselesaikan</strong> untuk melengkapkan pendaftaran sebagai atlet.</p>
      </div>
      <div class="auth-panel">
        <div class="auth-panel-ic"></div>
        <h2>Selamat Datang!</h2>
        <p>Sistem Pengurusan<br>Kelab Olahraga Shah Alam</p>
      </div>
    </div></div>
<div class="page" id="p-dash-atlet">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item active" onclick="go(&#39;p-dash-atlet&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-atlet&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-bayar-atlet&#39;)">Pembayaran</div><div class="sidebar-user" onclick="go(&#39;p-profil-atlet&#39;)" style="cursor:pointer;"><div class="av">AB</div><div><b>Ali bin Abu</b><span>Atlet</span></div></div></nav>
      <div class="content">
        <div class="pg-title">Dashboard</div>
        <div class="notif-bar" id="dashInvoisNotif" style="display:none;">⚠ <span id="dash-notif-teks"></span> <a class="link" onclick="go(&#39;p-bayar-atlet&#39;)">Bayar sekarang →</a></div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
          <div class="card card-body">
            <div class="metric-label" style="margin-bottom:6px;">Pakej Semasa</div>
            <div style="font-size:15px;font-weight:600;" id="dash-pakej">-</div>
            <div style="font-size:12px;color:var(--tx2);margin-top:2px;" id="dash-pakej-info">-</div>
          </div>
          <div class="card card-body">
            <div class="metric-label" style="margin-bottom:6px;" id="dash-hadir-label">Kehadiran</div>
            <div class="metric-val" style="color:var(--gn);" id="dash-hadir-pct">–</div>
            <div class="metric-note" id="dash-hadir-note">-</div>
          </div>
          <div class="card card-body">
            <div class="metric-label" style="margin-bottom:6px;">Status Yuran</div>
            <div style="margin-top:4px;" id="dash-yuran-badge"><span class="badge badge-default">-</span></div>
            <div class="metric-note" style="margin-top:6px;" id="dash-yuran-bulan">-</div>
          </div>
        </div>
        <div class="g2">
          <div class="card card-body">
            <div class="card-title">Prestasi Terkini</div>
            <table>
              <thead><tr><th>Acara</th><th>Terkini</th><th>Perubahan</th></tr></thead>
              <tbody id="dash-prestasi-tbody">
                <tr><td colspan="3" style="text-align:center;color:var(--tx3);">Memuatkan...</td></tr>
              </tbody>
            </table>
          </div>
          <div class="card card-body">
            <div class="card-title">Kehadiran Bulan Ini</div>
            <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:6px;"><span id="dash-hadir-bulan">-</span><span style="font-weight:600;" id="dash-hadir-sesi">0 / 0 sesi</span></div>
            <div class="prog-wrap"><div class="prog" style="width:0%;" id="dash-hadir-prog"></div></div>
            <div style="font-size:12.5px;color:var(--tx2);margin-top:10px;">Latihan seterusnya: <strong id="dash-latihan-seterusnya">-</strong></div>
          </div>
        </div>
      </div>
    </div></div>
<div class="page" id="p-profil-atlet">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-atlet&#39;)">Dashboard</div><div class="nav-item active" onclick="go(&#39;p-profil-atlet&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-bayar-atlet&#39;)">Pembayaran</div><div class="sidebar-user" onclick="go(&#39;p-profil-atlet&#39;)" style="cursor:pointer;"><div class="av">AB</div><div><b>Ali bin Abu</b><span>Atlet</span></div></div></nav>
    <div class="content">
        <div class="pg-hd">
          <div class="left"><div class="pg-title">Profil Saya</div></div>
          <button class="btn btn-primary btn-sm" onclick="openModal(&#39;modal-kemaskini-atlet-profil&#39;)">Kemaskini Profil</button>
      </div>
        <div class="card card-body">
          <div class="profile-hd">
            <div class="profile-av" id="atlet-avatar">-</div>
            <div><div class="profile-name" id="atlet-nama">Memuatkan...</div><span class="badge badge-success">Atlet Aktif</span></div>
          </div>
          <div class="info-grid">
            <div class="info-row"><div class="info-label">Nama Penuh</div><div class="info-val" id="atlet-nama-penuh">Memuatkan...</div></div>
            <div class="info-row"><div class="info-label">No. Kad Pengenalan</div><div class="info-val" id="atlet-no-kp">-</div></div>
            <div class="info-row"><div class="info-label">Tarikh Lahir</div><div class="info-val" id="atlet-tarikh-lahir">-</div></div>
            <div class="info-row"><div class="info-label">Pakej Sukan</div><div class="info-val" id="atlet-pakej">-</div></div>
            <div class="info-row"><div class="info-label">Sesi Latihan</div><div class="info-val" id="atlet-sesi">-</div></div>
            <div class="info-row"><div class="info-label">Nama Ibu/Bapa</div><div class="info-val" id="atlet-nama-waris">-</div></div>
            <div class="info-row"><div class="info-label">No. Telefon Waris</div><div class="info-val" id="atlet-tel-waris">-</div></div>
            <div class="info-row"><div class="info-label">E-mel</div><div class="info-val" id="atlet-emel">-</div></div>
            <div class="info-row"><div class="info-label">Kata Laluan</div><div class="info-val">••••••••••</div></div>
            <div class="info-row"><div class="info-label">Nama Sekolah</div><div class="info-val" id="atlet-sekolah">-</div></div>
          </div>
        </div>
      </div>
    </div></div>
<div class="page" id="p-bayar-atlet">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-atlet&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-atlet&#39;)">Profil</div><div class="nav-item active" onclick="go(&#39;p-bayar-atlet&#39;)">Pembayaran</div><div class="sidebar-user" onclick="go(&#39;p-profil-atlet&#39;)" style="cursor:pointer;"><div class="av">AB</div><div><b>Ali bin Abu</b><span>Atlet</span></div></div></nav>
      <div class="content">
        <div class="pg-title">Pembayaran</div>
        <div class="g2" style="margin-bottom:18px;">
          <div class="card card-body">
            <div class="card-title">Muat Naik Bukti Pembayaran</div>
            <div class="fg"><label>Bulan<span class="req">*</span></label><select class="inp" id="bayar-bulan" onchange="updateInvoisBulan()"></select></div>
            <input type="file" id="bukti-input" accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf" style="display:none;" onchange="hantarBukti(this)">
            <div class="upload-zone" onclick="pilihFailBukti()">
              <div class="icon">📁</div>
              <p>Klik untuk pilih fail</p>
              <small>JPG, PNG atau PDF · maks 5MB</small>
            </div>
          </div>
          <div class="card card-body" id="invoisTerkiniCard">
            <div class="card-title" id="invois-card-title">Invois</div>
            <div class="inv-card">
              <div class="inv-head">
                <div><div class="no" id="invois-no">-</div></div>
                <span class="badge badge-warning" id="invois-status-badge">-</span>
              </div>
              <div class="inv-row"><span class="k">Jumlah</span><span class="v" id="invois-jumlah" style="font-size:16px;font-weight:700;">-</span></div>
              <div class="inv-row"><span class="k">Tarikh akhir</span><span class="v" id="invois-tarikh-akhir" style="color:var(--rd);">-</span></div>
              <div class="inv-row" id="invois-bukti-row" style="display:none;"><span class="k">Bukti pembayaran</span><span class="v"><a class="link" style="font-size:12.5px;" onclick="lihatBuktiSaya()">Lihat</a> &nbsp; <a class="link" style="font-size:12.5px;color:var(--rd);" id="invois-padam-bukti" onclick="padamBuktiSaya()">Padam</a></span></div>
            </div>
            <div style="background:var(--bg);border-radius:var(--radius-sm);padding:11px 13px;margin-top:12px;font-size:12.5px;color:var(--tx2);">
              Bayar melalui pindahan bank ke:<br><strong style="color:var(--tx);">Maybank: 5621-0685-7064</strong> (Shah Alam Athletics)
            </div>
          </div>
          <div class="card card-body" id="invoisPaidMsg" style="display:none;align-items:center;justify-content:center;text-align:center;flex-direction:column;gap:8px;">
            <span style="font-size:32px;">✅</span>
            <p style="font-weight:600;">Semua yuran telah dibayar</p>
            <p style="font-size:12.5px;color:var(--tx2);">Tiada invois tertunggak buat masa ini.</p>
          </div>
        </div>
        <div class="card" style="padding:0;overflow:hidden;">
          <div style="padding:16px 20px 12px;border-bottom:1px solid var(--border);font-weight:600;">Sejarah Pembayaran</div>
          <table>
            <thead><tr><th>Bulan</th><th>Pakej</th><th>Amaun</th><th>Tarikh Bayar</th><th>Status</th></tr></thead>
            <tbody id="sejarah-bayar-tbody">
              <tr><td colspan="5" style="text-align:center;padding:24px;">Memuatkan rekod pembayaran...</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div></div>
<div class="page" id="p-dash-admin">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item active" onclick="go(&#39;p-dash-admin&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-admin&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-atlet-admin&#39;)">Senarai Atlet</div><div class="nav-item" onclick="go(&#39;p-pakej-admin&#39;)">Pakej Sukan</div><div class="nav-item" onclick="go(&#39;p-bayar-admin&#39;)">Pembayaran</div><div class="nav-item" onclick="go(&#39;p-prestasi-admin&#39;)">Prestasi</div><div class="nav-item" onclick="go(&#39;p-hadir-admin&#39;)">Kehadiran</div><div class="nav-item" onclick="go(&#39;p-jurulatih-admin&#39;)">Jurulatih</div><div class="sidebar-user" onclick="go(&#39;p-profil-admin&#39;)" style="cursor:pointer;"><div class="av">AM</div><div><b>Ahmad</b><span>Admin</span></div></div></nav>
      <div class="content">
        <div class="pg-title">Dashboard</div>
        <div class="metrics">
          <div class="metric">
            <div class="metric-top"><div class="metric-label">Jumlah Atlet</div><div class="metric-ic" style="background:var(--pri-l);color:var(--pri);">👥</div></div>
            <div class="metric-val" id="dash-admin-atlet">–</div>
            <div class="metric-note">Atlet aktif berdaftar</div>
          </div>
          <div class="metric">
            <div class="metric-top"><div class="metric-label" id="dash-admin-kutipan-label">Kutipan Yuran</div><div class="metric-ic" style="background:var(--gn-l);color:var(--gn);">💰</div></div>
            <div class="metric-val" id="dash-admin-kutipan">–</div>
            <div class="metric-note" id="dash-admin-kutipan-note">-</div>
          </div>
          <div class="metric">
            <div class="metric-top"><div class="metric-label">Kehadiran Purata</div><div class="metric-ic" style="background:var(--blue-l);color:var(--blue);">📅</div></div>
            <div class="metric-val" id="dash-admin-hadir">–</div>
            <div class="metric-note" id="dash-admin-hadir-note">-</div>
          </div>
          <div class="metric">
            <div class="metric-top"><div class="metric-label">Yuran Tertunggak</div><div class="metric-ic" style="background:var(--rd-l);color:var(--rd);">⚠</div></div>
            <div class="metric-val" style="color:var(--rd);" id="dash-admin-tertunggak">–</div>
            <div class="metric-note">Atlet belum bayar</div>
          </div>
        </div>
        <div class="g2">
          <div class="card card-body">
            <div class="card-title" id="dash-admin-carta-title">Kutipan Yuran (RM)</div>
            <div class="bar-chart" id="dash-admin-carta"></div>
          </div>
          <div class="card card-body" id="dash-admin-terkini">
            <div class="card-title">Pendaftaran Terkini</div>
          </div>
        </div>
      </div>
    </div></div>
<div class="page" id="p-profil-admin">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-admin&#39;)">Dashboard</div><div class="nav-item active" onclick="go(&#39;p-profil-admin&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-atlet-admin&#39;)">Senarai Atlet</div><div class="nav-item" onclick="go(&#39;p-pakej-admin&#39;)">Pakej Sukan</div><div class="nav-item" onclick="go(&#39;p-bayar-admin&#39;)">Pembayaran</div><div class="nav-item" onclick="go(&#39;p-prestasi-admin&#39;)">Prestasi</div><div class="nav-item" onclick="go(&#39;p-hadir-admin&#39;)">Kehadiran</div><div class="nav-item" onclick="go(&#39;p-jurulatih-admin&#39;)">Jurulatih</div><div class="sidebar-user" onclick="go(&#39;p-profil-admin&#39;)" style="cursor:pointer;"><div class="av">AM</div><div><b>Ahmad</b><span>Admin</span></div></div></nav>
      <div class="content">
        <div class="pg-hd">
          <div class="left"><div class="pg-title">Profil Admin</div></div>
          <button class="btn btn-primary btn-sm" onclick="openModal(&#39;modal-kemaskini-admin-profil&#39;)">Kemaskini Profil</button>
        </div>

<div class="card card-body">
    <div class="profile-hd">
        <div class="profile-av" id="admin-avatar">AD</div>
        <div>
            <div class="profile-name" id="admin-nama">Memuatkan...</div>
            <span class="badge badge-primary">Admin</span>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Nama Penuh</div>
            <div class="info-val" id="admin-nama-penuh">Memuatkan...</div>
        </div>

        <div class="info-row">
            <div class="info-label">No. Kad Pengenalan</div>
            <div class="info-val" id="admin-no-kp">-</div>
        </div>

        <div class="info-row">
            <div class="info-label">Tarikh Lahir</div>
            <div class="info-val" id="admin-tarikh-lahir">-</div>
        </div>

        <div class="info-row">
            <div class="info-label">No. Telefon</div>
            <div class="info-val" id="admin-no-telefon">-</div>
        </div>

        <div class="info-row">
            <div class="info-label">E-mel</div>
            <div class="info-val" id="admin-emel">-</div>
        </div>

        <div class="info-row">
            <div class="info-label">Kata Laluan</div>
            <div class="info-val">••••••••••</div>
        </div>
    </div>
</div>
      </div>
    </div></div>
<div class="page" id="p-atlet-admin">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-admin&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-admin&#39;)">Profil</div><div class="nav-item active" onclick="go(&#39;p-atlet-admin&#39;)">Senarai Atlet</div><div class="nav-item" onclick="go(&#39;p-pakej-admin&#39;)">Pakej Sukan</div><div class="nav-item" onclick="go(&#39;p-bayar-admin&#39;)">Pembayaran</div><div class="nav-item" onclick="go(&#39;p-prestasi-admin&#39;)">Prestasi</div><div class="nav-item" onclick="go(&#39;p-hadir-admin&#39;)">Kehadiran</div><div class="nav-item" onclick="go(&#39;p-jurulatih-admin&#39;)">Jurulatih</div><div class="sidebar-user" onclick="go(&#39;p-profil-admin&#39;)" style="cursor:pointer;"><div class="av">AM</div><div><b>Ahmad</b><span>Admin</span></div></div></nav>
      <div class="content">
        <div class="pg-hd">
          <div class="left"><div class="pg-title">Senarai Atlet</div></div>
          <div class="gap-row">
            <input class="inp" id="atlet-search" oninput="filterAtlet()" placeholder="Cari nama atau KP..." style="width:220px;">
            <select class="inp" id="atlet-pakej-filter" onchange="filterAtlet()" style="width:180px;"><option>Semua Pakej</option><option>Pakej Hari Sabtu</option><option>Pakej Hari Biasa</option><option>Pakej Lompat Tinggi</option><option>Pakej Latihan Lontaran</option><option>Pakej Larian Jarak Jauh (Dewasa)</option><option>Pakej Larian Jarak Jauh (9-18 Tahun)</option></select>
            <button class="btn btn-outline btn-sm" onclick="openReportAtlet()">Jana PDF</button>
          </div>
        </div>
        <div class="tbl-wrap">
          <table>
            <thead><tr><th>Nama Atlet</th><th>No. KP</th><th>Pakej</th><th>E-mel</th><th>Status</th><th>Tindakan</th></tr></thead>
<tbody id="atlet-tbody">
  <tr>
    <td colspan="6" style="text-align:center;padding:24px;">
      Memuatkan data atlet...
    </td>
  </tr>
</tbody>
          </table>
        </div>
      </div>
    </div></div>
<div class="page" id="p-pakej-admin">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-admin&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-admin&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-atlet-admin&#39;)">Senarai Atlet</div><div class="nav-item active" onclick="go(&#39;p-pakej-admin&#39;)">Pakej Sukan</div><div class="nav-item" onclick="go(&#39;p-bayar-admin&#39;)">Pembayaran</div><div class="nav-item" onclick="go(&#39;p-prestasi-admin&#39;)">Prestasi</div><div class="nav-item" onclick="go(&#39;p-hadir-admin&#39;)">Kehadiran</div><div class="nav-item" onclick="go(&#39;p-jurulatih-admin&#39;)">Jurulatih</div><div class="sidebar-user" onclick="go(&#39;p-profil-admin&#39;)" style="cursor:pointer;"><div class="av">AM</div><div><b>Ahmad</b><span>Admin</span></div></div></nav>
      <div class="content">
        <div class="pg-hd">
          <div class="left"><div class="pg-title">Pakej Sukan</div></div>
          <button class="btn btn-primary btn-sm" onclick="openModal(&#39;modal-tambah-pakej&#39;)">+ Tambah Pakej</button>
        </div>
        <div class="tbl-wrap">
          <table>
            <thead><tr><th>Poster</th><th>Nama Pakej</th><th>Sukan</th><th>Hari</th><th>Sesi</th><th>Yuran</th><th>Tindakan</th></tr></thead>
            <tbody id="pakej-tbody"><tr><td colspan="7" style="text-align:center;padding:24px;">Memuatkan data pakej...</td></tr></tbody>
          </table>
        </div>
      </div>
    </div></div>
<div class="page" id="p-bayar-admin">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-admin&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-admin&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-atlet-admin&#39;)">Senarai Atlet</div><div class="nav-item" onclick="go(&#39;p-pakej-admin&#39;)">Pakej Sukan</div><div class="nav-item active" onclick="go(&#39;p-bayar-admin&#39;)">Pembayaran</div><div class="nav-item" onclick="go(&#39;p-prestasi-admin&#39;)">Prestasi</div><div class="nav-item" onclick="go(&#39;p-hadir-admin&#39;)">Kehadiran</div><div class="nav-item" onclick="go(&#39;p-jurulatih-admin&#39;)">Jurulatih</div><div class="sidebar-user" onclick="go(&#39;p-profil-admin&#39;)" style="cursor:pointer;"><div class="av">AM</div><div><b>Ahmad</b><span>Admin</span></div></div></nav>
      <div class="content">
        <div class="pg-hd">
          <div class="left"><div class="pg-title">Pengurusan Pembayaran</div></div>
          <div class="gap-row">
            <input class="inp" id="bayar-search" oninput="filterBayar()" placeholder="Cari atlet..." style="width:190px;">
            <select class="inp" id="bayar-pakej-filter" onchange="filterBayar()" style="width:190px;"><option>Semua Pakej</option><option>Pakej Hari Sabtu</option><option>Pakej Hari Biasa</option><option>Pakej Lompat Tinggi</option><option>Pakej Latihan Lontaran</option><option>Pakej Larian Jarak Jauh (Dewasa)</option><option>Pakej Larian Jarak Jauh (9-18 Tahun)</option></select>
            <select class="inp" id="bayar-bulan-filter" onchange="filterBayar()" style="width:150px;"><option>Semua Bulan</option></select>
            <select class="inp" id="bayar-status-filter" onchange="filterBayar()" style="width:160px;"><option>Semua Status</option><option>Menunggu</option><option>Disahkan</option><option>Ditolak</option><option>Belum Ada Bukti</option></select>
          </div>
        </div>
        <div class="tbl-wrap">
          <table>
            <thead><tr><th>Nama Atlet</th><th>Bulan</th><th>Pakej</th><th>Amaun</th><th>Bukti</th><th>Status</th><th style="text-align:center;">Disemak</th></tr></thead>
            <tbody id="bayar-tbody"><tr><td colspan="7" style="text-align:center;padding:24px;">Memuatkan rekod pembayaran...</td></tr></tbody>
          </table>
        </div>
        <div style="display:flex;align-items:center;gap:14px;margin-top:14px;">
          <button class="btn btn-primary" onclick="saveBayar()">Simpan Perubahan</button>
          <button class="btn btn-outline" onclick="hantarPeringatan()">Hantar Peringatan</button>
          <span style="font-size:13px;color:var(--tx2);">Disahkan: <strong id="bayar-confirmed-count" style="color:var(--gn);">0</strong> / 0</span>
        </div>
      </div>
    </div></div>
<div class="page" id="p-prestasi-admin">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-admin&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-admin&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-atlet-admin&#39;)">Senarai Atlet</div><div class="nav-item" onclick="go(&#39;p-pakej-admin&#39;)">Pakej Sukan</div><div class="nav-item" onclick="go(&#39;p-bayar-admin&#39;)">Pembayaran</div><div class="nav-item active" onclick="go(&#39;p-prestasi-admin&#39;)">Prestasi</div><div class="nav-item" onclick="go(&#39;p-hadir-admin&#39;)">Kehadiran</div><div class="nav-item" onclick="go(&#39;p-jurulatih-admin&#39;)">Jurulatih</div><div class="sidebar-user" onclick="go(&#39;p-profil-admin&#39;)" style="cursor:pointer;"><div class="av">AM</div><div><b>Ahmad</b><span>Admin</span></div></div></nav>
      <div class="content">
        <div class="pg-hd">
          <div class="left"><div class="pg-title">Prestasi Atlet</div></div>
        </div>
        <div class="seg" style="max-width:300px;">
          <div class="seg-btn on" id="seg-prestasi-individu" onclick="setPrestasiView(&#39;individu&#39;)">Individu</div>
          <div class="seg-btn" id="seg-prestasi-keseluruhan" onclick="setPrestasiView(&#39;keseluruhan&#39;)">Keseluruhan</div>
        </div>
        <div id="prestasi-view-individu">
          <div class="gap-row" style="margin-bottom:14px;">
            <select class="inp" id="prestasi-athlete" onchange="updatePrestasiIndividu()" style="width:180px;"></select>
            <button class="btn btn-outline btn-sm" onclick="openModal(&#39;modal-tambah-prestasi&#39;)">+ Tambah Rekod</button>
            <button class="btn btn-primary btn-sm" onclick="openReportPrestasi()">Jana Graf</button>
          </div>
          <div class="tbl-wrap" style="margin-bottom:16px;">
            <table>
              <thead><tr><th>Acara</th><th style="text-align:center;">Bulan Lepas<br><span class="prestasi-bln-lepas" style="font-weight:400;text-transform:none;font-size:11px;">(-)</span></th><th style="text-align:center;">Bulan Ini<br><span class="prestasi-bln-ini" style="font-weight:400;text-transform:none;font-size:11px;">(-)</span></th><th style="text-align:center;">Perubahan</th><th>Tindakan</th></tr></thead>
              <tbody id="prestasi-individu-tbody"></tbody>
            </table>
          </div>
          <div class="card card-body">
            <div class="card-title" id="prestasi-graf-title">Graf Prestasi — Perubahan Semua Acara</div>
            <div class="bar-chart-diverge" id="prestasi-bar-chart"></div>
          </div>
        </div>
        <div id="prestasi-view-keseluruhan" style="display:none;">
          <div class="gap-row" style="margin-bottom:14px;">
            <select class="inp" id="prestasi-pakej-filter" onchange="updatePrestasiKeseluruhan()" style="width:200px;"><option>Semua Pakej</option><option>Pakej Hari Sabtu</option><option>Pakej Hari Biasa</option><option>Pakej Lompat Tinggi</option><option>Pakej Latihan Lontaran</option><option>Pakej Larian Jarak Jauh (Dewasa)</option><option>Pakej Larian Jarak Jauh (9-18 Tahun)</option></select>
            <select class="inp" id="prestasi-acara-filter" onchange="updatePrestasiKeseluruhan()" style="width:200px;"><option>Larian 100m (saat)</option><option>Lompat Jauh (m)</option><option>Lompat Tinggi (m)</option><option>Lontar Peluru (m)</option></select>
            <span style="font-size:12.5px;color:var(--tx2);" id="prestasi-top3-note">Menunjukkan 3 atlet terbaik bulan ini</span>
          </div>
          <div class="tbl-wrap">
            <table>
              <thead><tr><th>#</th><th>Nama Atlet</th><th>Pakej</th><th style="text-align:center;">Bulan Lepas<br><span class="prestasi-bln-lepas" style="font-weight:400;text-transform:none;font-size:11px;">(-)</span></th><th style="text-align:center;">Bulan Ini<br><span class="prestasi-bln-ini" style="font-weight:400;text-transform:none;font-size:11px;">(-)</span></th><th style="text-align:center;">Perubahan</th></tr></thead>
              <tbody id="prestasi-keseluruhan-tbody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div></div>
<div class="page" id="p-hadir-admin">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-admin&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-admin&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-atlet-admin&#39;)">Senarai Atlet</div><div class="nav-item" onclick="go(&#39;p-pakej-admin&#39;)">Pakej Sukan</div><div class="nav-item" onclick="go(&#39;p-bayar-admin&#39;)">Pembayaran</div><div class="nav-item" onclick="go(&#39;p-prestasi-admin&#39;)">Prestasi</div><div class="nav-item active" onclick="go(&#39;p-hadir-admin&#39;)">Kehadiran</div><div class="nav-item" onclick="go(&#39;p-jurulatih-admin&#39;)">Jurulatih</div><div class="sidebar-user" onclick="go(&#39;p-profil-admin&#39;)" style="cursor:pointer;"><div class="av">AM</div><div><b>Ahmad</b><span>Admin</span></div></div></nav>
      <div class="content">
        <div class="pg-hd">
          <div class="left"><div class="pg-title">Kehadiran Atlet</div></div>
        </div>
        <div class="seg" style="max-width:320px;">
          <div class="seg-btn on" id="seg-hadir-tanda" onclick="setHadirView(&#39;tanda&#39;)">Tanda Kehadiran</div>
          <div class="seg-btn" id="seg-hadir-laporan" onclick="setHadirView(&#39;laporan&#39;)">Laporan</div>
        </div>
        <div id="hadir-view-tanda">
        <div class="gap-row" style="margin:14px 0;">
            <input class="inp" type="date" id="hadir-tarikh" value="" onchange="loadHadir()" style="width:160px;">
            <select class="inp" id="hadir-pakej-filter" onchange="filterHadir()" style="width:180px;"><option>Semua Pakej</option><option>Pakej Hari Sabtu</option><option>Pakej Hari Biasa</option><option>Pakej Lompat Tinggi</option><option>Pakej Latihan Lontaran</option><option>Pakej Larian Jarak Jauh (Dewasa)</option><option>Pakej Larian Jarak Jauh (9-18 Tahun)</option></select>
            <select class="inp" id="hadir-sesi-filter" onchange="filterHadir()" style="width:190px;"><option>Semua Sesi</option><option>Sesi Petang</option><option>Sesi Malam</option></select>
            <button class="btn btn-outline btn-sm" onclick="tickAll()">✓ Semua Hadir</button>
        </div>
        <div class="tbl-wrap" style="margin-bottom:14px;">
          <table>
            <thead><tr><th>Nama Atlet</th><th>Pakej</th><th style="text-align:center;">Kehadiran</th><th style="text-align:center;">Peratus</th><th style="text-align:center;">Status</th><th>Tindakan</th></tr></thead>
            <tbody id="hadir-tbody"><tr><td colspan="6" style="text-align:center;padding:24px;">Memuatkan data kehadiran...</td></tr></tbody>
          </table>
        </div>
        <div style="display:flex;align-items:center;gap:14px;">
          <button class="btn btn-primary" onclick="simpanKehadiran()">Simpan Kehadiran</button>
          <span style="font-size:13px;color:var(--tx2);">Hadir ditanda: <strong id="hadir-count" style="color:var(--gn);">0</strong> / <span id="hadir-total">0</span></span>
        </div>
        </div>
        <div id="hadir-view-laporan" style="display:none;">
          <div class="seg" style="max-width:280px;margin-bottom:14px;">
            <div class="seg-btn on" id="seg-laporan-individu" onclick="setLaporanView(&#39;individu&#39;)">Individu</div>
            <div class="seg-btn" id="seg-laporan-keseluruhan" onclick="setLaporanView(&#39;keseluruhan&#39;)">Keseluruhan</div>
          </div>
          <div id="laporan-view-individu">
            <div class="gap-row" style="margin-bottom:14px;flex-wrap:wrap;">
              <select class="inp" id="laporan-pakej-individu" onchange="onLaporanPakejIndividuChange()" style="width:170px;"><option>Semua Pakej</option><option>Pakej Hari Sabtu</option><option>Pakej Hari Biasa</option><option>Pakej Lompat Tinggi</option><option>Pakej Latihan Lontaran</option><option>Pakej Larian Jarak Jauh (Dewasa)</option><option>Pakej Larian Jarak Jauh (9-18 Tahun)</option></select>
              <select class="inp" id="laporan-athlete" onchange="updateLaporanIndividu()" style="width:180px;"></select>
              <select class="inp" id="laporan-bulan-individu" onchange="setLaporanBulanIndividu()" style="width:140px;"><option value="custom">Julat Tersuai</option></select>
              <input class="inp" type="date" id="laporan-dari" value="" onchange="setLaporanCustomIndividu()" style="width:150px;">
              <input class="inp" type="date" id="laporan-hingga" value="" onchange="setLaporanCustomIndividu()" style="width:150px;">
              <button class="btn btn-primary btn-sm" onclick="updateLaporanIndividu();toast(&#39;Laporan kehadiran dijana!&#39;)">Jana Laporan</button>
              <button class="btn btn-outline btn-sm" onclick="openReportHadirIndividu()">Muat Turun PDF</button>
            </div>
            <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:16px;" id="laporan-individu-stats"></div>
            <div class="tbl-wrap">
              <table>
                <thead><tr><th>Tarikh</th><th>Status</th></tr></thead>
                <tbody id="laporan-individu-log"></tbody>
              </table>
            </div>
          </div>
          <div id="laporan-view-keseluruhan" style="display:none;">
            <div class="gap-row" style="margin-bottom:14px;flex-wrap:wrap;">
              <select class="inp" id="laporan-pakej-filter" onchange="updateLaporanKeseluruhan()" style="width:170px;"><option>Semua Pakej</option><option>Pakej Hari Sabtu</option><option>Pakej Hari Biasa</option><option>Pakej Lompat Tinggi</option><option>Pakej Latihan Lontaran</option><option>Pakej Larian Jarak Jauh (Dewasa)</option><option>Pakej Larian Jarak Jauh (9-18 Tahun)</option></select>
              <select class="inp" id="laporan-bulan-keseluruhan" onchange="setLaporanBulanKeseluruhan()" style="width:140px;"><option value="custom">Julat Tersuai</option></select>
              <input class="inp" type="date" id="laporan-k-dari" value="" onchange="setLaporanCustomKeseluruhan()" style="width:150px;">
              <input class="inp" type="date" id="laporan-k-hingga" value="" onchange="setLaporanCustomKeseluruhan()" style="width:150px;">
              <button class="btn btn-primary btn-sm" onclick="updateLaporanKeseluruhan();toast(&#39;Laporan kehadiran dijana!&#39;)">Jana Laporan</button>
              <button class="btn btn-outline btn-sm" onclick="openReportHadirKeseluruhan()">Muat Turun PDF</button>
            </div>
            <div class="tbl-wrap">
              <table>
                <thead><tr><th>#</th><th>Nama Atlet</th><th>Pakej</th><th style="text-align:center;">Hadir</th><th style="text-align:center;">Tidak Hadir</th><th style="text-align:center;">Peratus</th></tr></thead>
                <tbody id="laporan-keseluruhan-tbody"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div></div>
<div class="page" id="p-jurulatih-admin">
    <div class="topbar"><div class="logo"><div class="logo-mark"></div><span>AthleteTrack</span></div><button class="btn btn-primary btn-sm" onclick="logoutAction()">Log Keluar</button></div>
    <div class="app-body">
      <nav class="sidebar"><div class="nav-item" onclick="go(&#39;p-dash-admin&#39;)">Dashboard</div><div class="nav-item" onclick="go(&#39;p-profil-admin&#39;)">Profil</div><div class="nav-item" onclick="go(&#39;p-atlet-admin&#39;)">Senarai Atlet</div><div class="nav-item" onclick="go(&#39;p-pakej-admin&#39;)">Pakej Sukan</div><div class="nav-item" onclick="go(&#39;p-bayar-admin&#39;)">Pembayaran</div><div class="nav-item" onclick="go(&#39;p-prestasi-admin&#39;)">Prestasi</div><div class="nav-item" onclick="go(&#39;p-hadir-admin&#39;)">Kehadiran</div><div class="nav-item active" onclick="go(&#39;p-jurulatih-admin&#39;)">Jurulatih</div><div class="sidebar-user" onclick="go(&#39;p-profil-admin&#39;)" style="cursor:pointer;"><div class="av">AM</div><div><b>Ahmad</b><span>Admin</span></div></div></nav>
      <div class="content">
        <div class="pg-hd">
          <div class="left"><div class="pg-title">Senarai Jurulatih</div></div>
          <button class="btn btn-primary btn-sm" onclick="openModal(&#39;modal-tambah-jurulatih&#39;)">+ Tambah Jurulatih</button>
        </div>
        <div class="tbl-wrap">
          <table>
            <thead><tr><th>Nama</th><th>No. KP</th><th>Kepakaran</th><th>No. Telefon</th><th>E-mel</th><th>Tindakan</th></tr></thead>
            <tbody id="jurulatih-tbody"><tr><td colspan="6" style="text-align:center;padding:24px;">Memuatkan data jurulatih...</td></tr></tbody>
          </table>
        </div>
      </div>
    </div></div>

<div class="modal-bg" id="modal-laporan-preview">
  <div class="report-modal-card">
    <div class="report-banner no-print">
      <span>PRATONTON LAPORAN</span>
      <button class="report-close" onclick="closeModal(&#39;modal-laporan-preview&#39;)">✕</button>
    </div>
    <div class="report-body" id="reportPrintArea"></div>
    <div class="report-ft no-print">
      <button class="btn btn-outline" style="flex:1;" onclick="closeModal(&#39;modal-laporan-preview&#39;)">Tutup</button>
      <button class="btn btn-primary" style="flex:1;" onclick="window.print()">🖨️ Cetak / Muat Turun PDF</button>
    </div>
  </div>
</div>

<div class="modal-bg" id="modal-padam">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Padam Rekod Ini?</div><div class="modal-sub">Tindakan ini tidak boleh dibatalkan.</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-padam&#39;)">✕</button>
    </div>
    <div class="modal-body"><div style="text-align:center;padding:10px 0;"><div style="font-size:40px;margin-bottom:10px;">🗑</div><p style="color:var(--tx2);font-size:13.5px;line-height:1.65;">Data yang dipadam tidak dapat dipulihkan.<br>Adakah anda pasti mahu meneruskan?</p></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button>
<button class="btn btn-danger" onclick="sahkanPadam()">Ya, Padam</button>
  </div>
  </div>
</div>
<div class="modal-bg" id="modal-kemaskini-atlet">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Kemaskini Maklumat Atlet</div><div class="modal-sub">Ubah butiran atlet yang dipilih</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-kemaskini-atlet&#39;)">✕</button>
    </div>
    <div class="modal-body"><div class="fg"><label>Nama Penuh<span class="req">*</span></label><input class="inp" id="m-atlet-nama" type="text" placeholder="Nama penuh"></div><div class="fg"><label>No. Kad Pengenalan<span class="req">*</span></label><input class="inp" id="m-atlet-kp" type="text" placeholder="Contoh: 070908-01-1150"></div><div class="g2"><div class="fg"><label>Tarikh Lahir<span class="req">*</span></label><input class="inp" id="m-atlet-tarikhlahir" type="date" placeholder=""></div><div class="fg"><label>Pakej Sukan<span class="req">*</span></label><select class="inp" id="m-atlet-pakej"><option>Pakej Hari Sabtu</option><option>Pakej Hari Biasa</option><option>Pakej Lompat Tinggi</option><option>Pakej Latihan Lontaran</option><option>Pakej Larian Jarak Jauh (Dewasa)</option><option>Pakej Larian Jarak Jauh (9-18 Tahun)</option></select></div></div><div class="fg"><label>Sesi Latihan<span class="req">*</span></label><select class="inp" id="m-atlet-sesi"><option>Sesi Petang (5.00pm – 6.15pm)</option><option>Sesi Malam (8.00pm – 9.15pm)</option></select></div><div class="fg"><label>No. Telefon Waris<span class="req">*</span></label><input class="inp" id="m-atlet-telwaris" type="tel" placeholder="012-xxxxxxx"></div><div class="fg"><label>E-mel<span class="req">*</span></label><input class="inp" id="m-atlet-emel" type="email" placeholder="emel@gmail.com"></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button>
    <button class="btn btn-primary" onclick="simpanKemaskiniAtlet()">Simpan</button>
</div>
  </div>
</div>
<div class="modal-bg" id="modal-kemaskini-atlet-profil">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Kemaskini Profil</div><div class="modal-sub">Ubah maklumat dan kata laluan akaun anda</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-kemaskini-atlet-profil&#39;)">✕</button>
    </div>
    <div class="modal-body">
      <p style="font-size:11.5px;font-weight:600;color:var(--tx3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:10px;">Maklumat Tetap (Hubungi Admin untuk Kemaskini)</p>
<div class="g2">
  <div class="fg locked">
    <label>No. Kad Pengenalan</label>
    <input class="inp" id="profil-atlet-kp" type="text" value="" disabled>
  </div>
  <div class="fg locked">
    <label>Tarikh Lahir</label>
    <input class="inp" id="profil-atlet-tarikhlahir" type="date" value="" disabled>
  </div>
</div>

<div class="g2">
  <div class="fg locked">
    <label>Pakej Sukan</label>
    <input class="inp" id="profil-atlet-pakej" type="text" value="" disabled>
  </div>
  <div class="fg locked">
    <label>Sesi Latihan</label>
    <input class="inp" id="profil-atlet-sesi" type="text" value="" disabled>
  </div>
</div>
      <hr class="divider">
      <div class="fg"><label>Nama Penuh<span class="req">*</span></label><input class="inp" id="profil-atlet-nama" type="text" placeholder="Nama penuh"></div><div class="fg"><label>Nama Ibu/Bapa<span class="req">*</span></label><input class="inp" id="profil-atlet-namawaris" type="text" placeholder="Nama ibu/bapa/penjaga"></div><div class="fg"><label>Nama Sekolah</label><input class="inp" id="profil-atlet-sekolah" type="text" placeholder="Kosongkan jika tidak bersekolah"></div><div class="fg"><label>No. Telefon Waris<span class="req">*</span></label><input class="inp" id="profil-atlet-telwaris" type="tel" placeholder="012-xxxxxxx"></div><div class="fg"><label>Alamat E-mel<span class="req">*</span></label><input class="inp" id="profil-atlet-emel" type="email" placeholder="emel@gmail.com"></div><hr class="divider"><p style="font-size:12.5px;font-weight:600;color:var(--tx2);margin-bottom:12px;">TUKAR KATA LALUAN</p><div class="fg"><label>Kata laluan semasa</label><input class="inp" id="profil-atlet-pass-lama" type="password" placeholder=""></div><div class="fg"><label>Kata laluan baharu</label><input class="inp" id="profil-atlet-pass-baru" type="password" placeholder="Sekurang-kurangnya 8 aksara"></div><div class="fg"><label>Sahkan kata laluan</label><input class="inp" id="profil-atlet-pass-sahkan" type="password" placeholder=""></div></div>
<div class="modal-ft">
  <button class="btn btn-outline" onclick="closeModal(this.closest('.modal-bg').id)">Batal</button>
  <button class="btn btn-primary" onclick="simpanProfilAtlet()">Simpan</button>
</div>
</div>
</div>
<div class="modal-bg" id="modal-kemaskini-admin-profil">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Kemaskini Profil Admin</div><div class="modal-sub">Ubah maklumat dan kata laluan akaun admin</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-kemaskini-admin-profil&#39;)">✕</button>
    </div>
    <div class="modal-body">
      <div class="fg"><label>Nama Penuh<span class="req">*</span></label><input class="inp" id="profil-admin-nama" type="text" placeholder="Nama penuh"></div>
      <div class="g2">
        <div class="fg"><label>No. Kad Pengenalan</label><input class="inp" id="profil-admin-kp" type="text" value="" placeholder="Contoh: 820609-01-5371"></div>
        <div class="fg"><label>Tarikh Lahir</label><input class="inp" id="profil-admin-tarikhlahir" type="date" value=""></div>
      </div>
      <div class="fg"><label>No. Telefon</label><input class="inp" id="profil-admin-tel" type="tel" placeholder="019-xxxxxxx"></div><div class="fg"><label>Alamat E-mel<span class="req">*</span></label><input class="inp" id="profil-admin-emel" type="email" placeholder="emel@kosa.my"></div><hr class="divider"><p style="font-size:12.5px;font-weight:600;color:var(--tx2);margin-bottom:12px;">TUKAR KATA LALUAN</p><div class="fg"><label>Kata laluan semasa</label><input class="inp" id="profil-admin-pass-lama" type="password" placeholder=""></div><div class="fg"><label>Kata laluan baharu</label><input class="inp" id="profil-admin-pass-baru" type="password" placeholder=""></div><div class="fg"><label>Sahkan kata laluan</label><input class="inp" id="profil-admin-pass-sahkan" type="password" placeholder=""></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button><button class="btn btn-primary" onclick="simpanProfilAdmin()">Simpan</button></div>
  </div>
</div>
<div class="modal-bg" id="modal-tambah-pakej">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Tambah Pakej Sukan</div><div class="modal-sub">Isi butiran pakej latihan baharu</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-tambah-pakej&#39;)">✕</button>
    </div>
    <div class="modal-body"><div class="fg"><label>Nama Pakej<span class="req">*</span></label><input class="inp" id="m-pakej-nama" type="text" placeholder="Contoh: Pakej Hari Sabtu"></div><div class="fg"><label>Sukan<span class="req">*</span></label><input class="inp" id="m-pakej-sukan" type="text" placeholder="Contoh: Track &amp; Field (Larian Pecut &amp; Asas)"></div><div class="g2"><div class="fg"><label>Hari Latihan<span class="req">*</span></label><input class="inp" id="m-pakej-hari" type="text" placeholder="Contoh: Isnin &amp; Khamis"></div><div class="fg"><label>Yuran (RM)<span class="req">*</span></label><input class="inp" id="m-pakej-yuran" type="number" placeholder="Contoh: 180"></div></div><div class="fg"><label>Sesi<span class="req">*</span></label><select class="inp" id="m-pakej-sesi"><option>Pagi</option><option>Petang</option><option>Malam</option><option>Petang / Malam</option></select></div><div class="fg"><label>Poster Pakej</label><input type="file" id="m-pakej-poster" accept="image/jpeg,image/png" style="display:none;" onchange="pilihPoster(this)"><div class="upload-zone" onclick="document.getElementById(&#39;m-pakej-poster&#39;).click()"><div class="icon">📁</div><p>Klik untuk muat naik poster</p><small>JPG atau PNG · 600x800px dicadangkan</small></div></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button><button class="btn btn-primary" onclick="simpanPakej(&#39;tambah&#39;)">Simpan</button></div>
  </div>
</div>
<div class="modal-bg" id="modal-kemaskini-pakej">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Kemaskini Pakej Sukan</div><div class="modal-sub">Ubah butiran pakej yang dipilih</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-kemaskini-pakej&#39;)">✕</button>
    </div>
    <div class="modal-body"><div class="fg"><label>Nama Pakej<span class="req">*</span></label><input class="inp" id="m-pakej-edit-nama" type="text" placeholder="Contoh: Pakej Hari Sabtu"></div><div class="fg"><label>Sukan<span class="req">*</span></label><input class="inp" id="m-pakej-edit-sukan" type="text" placeholder="Contoh: Track &amp; Field (Larian Pecut &amp; Asas)"></div><div class="g2"><div class="fg"><label>Hari Latihan<span class="req">*</span></label><input class="inp" id="m-pakej-edit-hari" type="text" placeholder="Contoh: Isnin &amp; Khamis"></div><div class="fg"><label>Yuran (RM)<span class="req">*</span></label><input class="inp" id="m-pakej-edit-yuran" type="number" placeholder="Contoh: 180"></div></div><div class="fg"><label>Sesi<span class="req">*</span></label><select class="inp" id="m-pakej-edit-sesi"><option>Pagi</option><option>Petang</option><option>Malam</option><option>Petang / Malam</option></select></div><div class="fg"><label>Poster Pakej</label><input type="file" id="m-pakej-edit-poster" accept="image/jpeg,image/png" style="display:none;" onchange="pilihPoster(this)"><div class="upload-zone" onclick="document.getElementById(&#39;m-pakej-edit-poster&#39;).click()"><div class="icon">📁</div><p>Klik untuk muat naik poster</p><small>JPG atau PNG · 600x800px dicadangkan</small></div></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button><button class="btn btn-primary" onclick="simpanPakej(&#39;kemaskini&#39;)">Simpan</button></div>
  </div>
</div>
<div class="modal-bg" id="modal-tambah-prestasi">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Tambah Rekod Prestasi</div><div class="modal-sub">Rekod bacaan prestasi atlet</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-tambah-prestasi&#39;)">✕</button>
    </div>
    <div class="modal-body"><div class="fg"><label>Atlet<span class="req">*</span></label><select class="inp" id="m-prestasi-atlet"></select></div><div class="fg"><label>Acara<span class="req">*</span></label><select class="inp" id="m-prestasi-acara"><option>Larian 100m (saat)</option><option>Lompat Jauh (m)</option><option>Lompat Tinggi (m)</option><option>Lontar Peluru (m)</option></select></div><div class="g2"><div class="fg"><label>Bulan<span class="req">*</span></label><select class="inp" id="m-prestasi-bulan"></select></div><div class="fg"><label>Bacaan<span class="req">*</span></label><input class="inp" id="m-prestasi-bacaan" type="number" placeholder="Contoh: 13.5"></div></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button><button class="btn btn-primary" onclick="simpanPrestasi(&#39;tambah&#39;)">Simpan</button></div>
  </div>
</div>
<div class="modal-bg" id="modal-kemaskini-prestasi">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Kemaskini Rekod Prestasi</div><div class="modal-sub">Ubah bacaan prestasi yang dipilih</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-kemaskini-prestasi&#39;)">✕</button>
    </div>
    <div class="modal-body"><div class="fg"><label>Atlet<span class="req">*</span></label><select class="inp" id="m-prestasi-edit-atlet"></select></div><div class="fg"><label>Acara<span class="req">*</span></label><select class="inp" id="m-prestasi-edit-acara"><option>Larian 100m (saat)</option><option>Lompat Jauh (m)</option><option>Lompat Tinggi (m)</option><option>Lontar Peluru (m)</option></select></div><div class="g2"><div class="fg"><label>Bulan<span class="req">*</span></label><select class="inp" id="m-prestasi-edit-bulan"></select></div><div class="fg"><label>Bacaan<span class="req">*</span></label><input class="inp" id="m-prestasi-edit-bacaan" type="number" placeholder="Contoh: 13.5"></div></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button><button class="btn btn-primary" onclick="simpanPrestasi(&#39;kemaskini&#39;)">Simpan</button></div>
  </div>
</div>
<div class="modal-bg" id="modal-kemaskini-hadir">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Kemaskini Kehadiran</div><div class="modal-sub">Ubah rekod kehadiran yang dipilih</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-kemaskini-hadir&#39;)">✕</button>
    </div>
    <div class="modal-body"><div class="fg"><label>Atlet<span class="req">*</span></label><select class="inp" id="m-hadir-atlet"></select></div><div class="g2"><div class="fg"><label>Tarikh<span class="req">*</span></label><input class="inp" id="m-hadir-tarikh" type="date" placeholder=""></div><div class="fg"><label>Sesi<span class="req">*</span></label><select class="inp" id="m-hadir-sesi"><option>Sesi Pagi</option><option>Sesi Petang</option><option>Sesi Malam</option></select></div></div><div class="fg"><label>Status<span class="req">*</span></label><select class="inp" id="m-hadir-status"><option>Hadir</option><option>Tidak Hadir</option></select></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button><button class="btn btn-primary" onclick="simpanKemaskiniHadir()">Simpan</button></div>
  </div>
</div>
<div class="modal-bg" id="modal-tambah-jurulatih">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Tambah Jurulatih</div><div class="modal-sub">Isi maklumat jurulatih baharu</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-tambah-jurulatih&#39;)">✕</button>
    </div>
    <div class="modal-body"><div class="fg"><label>Nama Penuh<span class="req">*</span></label><input class="inp" id="m-jurulatih-nama" type="text" placeholder="Nama penuh jurulatih"></div><div class="fg"><label>No. Kad Pengenalan<span class="req">*</span></label><input class="inp" id="m-jurulatih-kp" type="text" placeholder="Contoh: 850412-10-5566"></div><div class="g2"><div class="fg"><label>Tarikh Lahir<span class="req">*</span></label><input class="inp" id="m-jurulatih-tarikhlahir" type="date" placeholder=""></div><div class="fg"><label>Kepakaran<span class="req">*</span></label><select class="inp" id="m-jurulatih-kepakaran"><option>Pecut 100m</option><option>Pecut 200m</option><option>Lompat Jauh</option><option>Lompat Tinggi</option><option>Larian Jarak Jauh</option><option>Maraton</option></select></div></div><div class="g2"><div class="fg"><label>No. Telefon<span class="req">*</span></label><input class="inp" id="m-jurulatih-tel" type="tel" placeholder="012-xxxxxxx"></div><div class="fg"><label>E-mel<span class="req">*</span></label><input class="inp" id="m-jurulatih-emel" type="email" placeholder="nama@kosa.my"></div></div><hr class="divider"><p style="font-size:12.5px;font-weight:600;color:var(--tx2);margin-bottom:12px;">MAKLUMAT WARIS</p><div class="fg"><label>Nama Waris<span class="req">*</span></label><input class="inp" id="m-jurulatih-namawaris" type="text" placeholder="Nama waris terdekat"></div><div class="g2"><div class="fg"><label>No. Tel Waris<span class="req">*</span></label><input class="inp" id="m-jurulatih-telwaris" type="tel" placeholder="012-xxxxxxx"></div><div class="fg"><label>E-mel Waris</label><input class="inp" id="m-jurulatih-emelwaris" type="email" placeholder=""></div></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button><button class="btn btn-primary" onclick="simpanJurulatih(&#39;tambah&#39;)">Simpan</button></div>
  </div>
</div>
<div class="modal-bg" id="modal-kemaskini-jurulatih">
  <div class="modal">
    <div class="modal-hd">
      <div><div class="modal-title">Kemaskini Maklumat Jurulatih</div><div class="modal-sub">Ubah butiran jurulatih yang dipilih</div></div>
      <button class="modal-close" onclick="closeModal(&#39;modal-kemaskini-jurulatih&#39;)">✕</button>
    </div>
    <div class="modal-body"><div class="fg"><label>Nama Penuh<span class="req">*</span></label><input class="inp" id="m-jurulatih-edit-nama" type="text" placeholder="Nama penuh jurulatih"></div><div class="fg"><label>No. Kad Pengenalan<span class="req">*</span></label><input class="inp" id="m-jurulatih-edit-kp" type="text" placeholder="Contoh: 850412-10-5566"></div><div class="g2"><div class="fg"><label>Tarikh Lahir<span class="req">*</span></label><input class="inp" id="m-jurulatih-edit-tarikhlahir" type="date" placeholder=""></div><div class="fg"><label>Kepakaran<span class="req">*</span></label><select class="inp" id="m-jurulatih-edit-kepakaran"><option>Pecut 100m</option><option>Pecut 200m</option><option>Lompat Jauh</option><option>Lompat Tinggi</option><option>Larian Jarak Jauh</option><option>Maraton</option></select></div></div><div class="g2"><div class="fg"><label>No. Telefon<span class="req">*</span></label><input class="inp" id="m-jurulatih-edit-tel" type="tel" placeholder="012-xxxxxxx"></div><div class="fg"><label>E-mel<span class="req">*</span></label><input class="inp" id="m-jurulatih-edit-emel" type="email" placeholder="nama@kosa.my"></div></div><hr class="divider"><p style="font-size:12.5px;font-weight:600;color:var(--tx2);margin-bottom:12px;">MAKLUMAT WARIS</p><div class="fg"><label>Nama Waris<span class="req">*</span></label><input class="inp" id="m-jurulatih-edit-namawaris" type="text" placeholder="Nama waris terdekat"></div><div class="g2"><div class="fg"><label>No. Tel Waris<span class="req">*</span></label><input class="inp" id="m-jurulatih-edit-telwaris" type="tel" placeholder="012-xxxxxxx"></div><div class="fg"><label>E-mel Waris</label><input class="inp" id="m-jurulatih-edit-emelwaris" type="email" placeholder=""></div></div></div>
    <div class="modal-ft"><button class="btn btn-outline" onclick="closeModal(this.closest(&#39;.modal-bg&#39;).id)">Batal</button><button class="btn btn-primary" onclick="simpanJurulatih(&#39;kemaskini&#39;)">Simpan</button></div>
  </div>
</div>
<script>
/* ── Sesi pengguna & navigasi ── */
var SESI=null; // {id, nama, peranan} pengguna yang sedang log masuk
var HALAMAN_ATLET=['p-dash-atlet','p-profil-atlet','p-bayar-atlet'];
var HALAMAN_ADMIN=['p-dash-admin','p-profil-admin','p-atlet-admin','p-pakej-admin','p-bayar-admin','p-prestasi-admin','p-hadir-admin','p-jurulatih-admin'];
function perananHalaman(id){return HALAMAN_ADMIN.indexOf(id)>-1?'admin':HALAMAN_ATLET.indexOf(id)>-1?'atlet':null;}
function dashboardPeranan(){return SESI&&SESI.peranan==='admin'?'p-dash-admin':'p-dash-atlet';}
function simpanStorage(k,v){try{if(v===null)sessionStorage.removeItem(k);else sessionStorage.setItem(k,v);}catch(e){}}
function bacaStorage(k){try{return sessionStorage.getItem(k);}catch(e){return null;}}

function go(id) {
    // Halaman admin/atlet hanya boleh dibuka oleh pengguna dengan peranan yang betul.
    var perlu = perananHalaman(id);
    if (perlu && (!SESI || SESI.peranan !== perlu)) {
        id = SESI ? dashboardPeranan() : 'p-login';
        perlu = perananHalaman(id);
    }
    // Carta alir atlet: pembayaran pertama wajib dibuat sebelum boleh ke dashboard.
    if (perlu === 'atlet' && SESI.invois_daftar) {
        DAFTAR_INVOIS = SESI.invois_daftar;
        id = 'p-invois';
        toast('Sila buat pembayaran.');
    }

    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));

    var el = document.getElementById(id);

    if (el) {
        el.classList.add('active');
        window.scrollTo(0, 0);
    }

    if (SESI && perananHalaman(id)) simpanStorage('at_halaman', id);
    paparNamaPengguna();

    var pemuat = PEMUAT_HALAMAN[id];
    if (pemuat) pemuat();
}
function inisial(nama){
  return String(nama||'').trim().split(/\s+/).filter(Boolean).slice(0,2).map(function(p){return p.charAt(0);}).join('').toUpperCase()||'-';
}
// Nama & avatar di sidebar sentiasa mengikut akaun yang sedang log masuk.
function paparNamaPengguna(){
  if(!SESI)return;
  document.querySelectorAll('.sidebar-user').forEach(function(su){
    var av=su.querySelector('.av'),b=su.querySelector('b');
    if(av)av.textContent=inisial(SESI.nama);
    if(b)b.textContent=SESI.nama;
  });
}

/* ── Utiliti ── */
function esc(teks){
  return String(teks ?? '').replace(/[&<>"']/g,function(a){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[a];});
}
function rm2(n){return 'RM'+Number(n||0).toLocaleString('en-MY',{minimumFractionDigits:2,maximumFractionDigits:2});}
function rm0(n){return 'RM'+Number(n||0).toLocaleString('en-MY',{maximumFractionDigits:2});}
// Panggilan API: pulangkan JSON jika berjaya, jika tidak lemparkan Error dengan mesej pelayan.
async function api(url,opts){
  var r=await fetch(url,Object.assign({credentials:'same-origin'},opts||{}));
  var j;
  try{j=await r.json();}catch(e){throw new Error('Respons pelayan tidak sah. Semak log ralat Apache.');}
  if(r.status===401&&SESI){
    SESI=null;simpanStorage('at_halaman',null);
    toast('Sesi anda telah tamat. Sila log masuk semula.');go('p-login');
  }
  if(!r.ok||!j.success)throw new Error(j.message||'Permintaan gagal. Sila cuba lagi.');
  return j;
}
function postJson(url,data){
  return api(url,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(data)});
}
function ralat(error,mesejLalai){
  console.error(error);
  toast(error&&error.message&&error.message!=='Failed to fetch'?error.message:(mesejLalai||'Tidak dapat menghubungi server. Sila cuba lagi.'));
}
function bulanSemasaKod(offset){var d=new Date();d.setDate(1);d.setMonth(d.getMonth()+(offset||0));return d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0');}
function namaBulanKod(kod){var p=kod.split('-');return BULAN_MS[parseInt(p[1],10)-1]+' '+p[0];}
function tarikhHariIni(){var d=new Date();return d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0');}

var PAKEJ_SESI={
  'Hari Biasa':['Sesi Petang (5.00pm – 6.15pm)','Sesi Malam (8.00pm – 9.15pm)'],
  'Hari Sabtu':['Sesi Petang (5.00pm – 6.30pm)'],
  'Lompat Tinggi':['Sesi Petang (5.00pm – 6.30pm)'],
  'Latihan Lontaran':['Sesi Malam (8.00pm – 9.00pm)'],
  'Larian Jarak Jauh (Dewasa)':['Sesi Malam (8.00pm – 9.15pm)'],
  'Larian Jarak Jauh (9-18 Tahun)':['Sesi Malam (8.00pm – 9.15pm)']
};
function updateDaftarSesi(){
  var pakej=document.getElementById('daftarPakej').value;
  var sesiSel=document.getElementById('daftarSesi');
  var opts=pakej?(PAKEJ_SESI[pakej]||sesiUntukPakej(pakej)):null;
  if(!opts||!opts.length){sesiSel.innerHTML='<option>-- Pilih sesi --</option>';return;}
  sesiSel.innerHTML=opts.map(function(s){return '<option>'+s+'</option>';}).join('');
}
// Pilihan sesi bagi pakej (nama penuh "Pakej ..."), termasuk pakej baharu yang ditambah admin.
function sesiUntukPakej(namaPakej){
  var kunci=String(namaPakej||'').replace(/^Pakej /,'');
  if(PAKEJ_SESI[kunci])return PAKEJ_SESI[kunci];
  var p=(PAKEJ_SENARAI||[]).find(function(x){return x.nama_pakej===namaPakej;});
  var jenis=p&&p.sesi?p.sesi.split('/').map(function(s){return s.trim();}).filter(Boolean):['Pagi','Petang','Malam'];
  return jenis.map(function(s){return 'Sesi '+s;});
}

/* ── Pembayaran atlet ── */
var ATLET_YURAN={sudahBayar:true};
var INVOIS_BULAN_DATA={};
var STATUS_BAYAR={
  belum:{teks:'Belum Bayar',badge:'badge-warning'},
  menunggu_sahkan:{teks:'Menunggu',badge:'badge-warning'},
  sudah:{teks:'Disahkan',badge:'badge-success'},
  ditolak:{teks:'Ditolak',badge:'badge-danger'}
};
function updateInvoisBulan(){
  var bulan=document.getElementById('bayar-bulan').value;
  var d=INVOIS_BULAN_DATA[bulan];
  if(!d)return;
  document.getElementById('invois-card-title').textContent='Invois ('+bulan+')';
  document.getElementById('invois-no').textContent=d.no;
  document.getElementById('invois-jumlah').textContent=d.jumlah;
  document.getElementById('invois-tarikh-akhir').textContent=d.tarikhAkhir;
  var badge=document.getElementById('invois-status-badge');
  badge.textContent=d.status;
  badge.className='badge '+d.badgeClass;
  // Bukti yang telah dimuat naik boleh dilihat; boleh dipadam selagi belum disemak admin.
  // Resit yuran pendaftaran hanya boleh ditukar (diganti dengan resit baharu), bukan dipadam.
  document.getElementById('invois-bukti-row').style.display=d.adaBukti?'':'none';
  var padam=document.getElementById('invois-padam-bukti');
  padam.style.display=d.kod==='menunggu_sahkan'?'':'none';
  padam.textContent=d.pertama?'Tukar':'Padam';
}
function refreshAtletInvois(){
  // Kad invois dipaparkan selagi ada invois yang belum disahkan (termasuk yang menunggu pengesahan).
  var belum=!ATLET_YURAN.sudahBayar;
  var card=document.getElementById('invoisTerkiniCard');
  if(card)card.style.display=belum?'':'none';
  var paidMsg=document.getElementById('invoisPaidMsg');
  if(paidMsg)paidMsg.style.display=belum?'none':'flex';
  updateInvoisBulan();
}
async function muatkanPembayaranAtlet(){
  var tbody=document.getElementById('sejarah-bayar-tbody');
  try{
    var invois=(await api('api/pembayaran-atlet.php')).data;
    INVOIS_BULAN_DATA={};
    var idPertama=Math.min.apply(null,invois.map(function(i){return i.id;}));
    invois.forEach(function(i){
      var st=STATUS_BAYAR[i.status]||STATUS_BAYAR.belum;
      INVOIS_BULAN_DATA[i.bulan]={id:i.id,no:i.no,jumlah:rm2(i.jumlah),tarikhAkhir:formatTarikh(i.tarikh_akhir),status:st.teks,badgeClass:st.badge,kod:i.status,adaBukti:i.ada_bukti,pertama:i.id===idPertama};
    });
    var belumSah=invois.filter(function(i){return i.status!=='sudah';});
    var tertunggak=invois.filter(function(i){return i.status==='belum'||i.status==='ditolak';});
    ATLET_YURAN.sudahBayar=belumSah.length===0;
    var sel=document.getElementById('bayar-bulan');
    var dipilih=sel.value;
    sel.innerHTML=invois.map(function(i){return '<option>'+esc(i.bulan)+'</option>';}).join('');
    if(INVOIS_BULAN_DATA[dipilih])sel.value=dipilih;
    else if(tertunggak.length)sel.value=tertunggak[tertunggak.length-1].bulan;
    else if(belumSah.length)sel.value=belumSah[belumSah.length-1].bulan;
    tbody.innerHTML=invois.length?invois.map(function(i){
      var st=STATUS_BAYAR[i.status]||STATUS_BAYAR.belum;
      var tebal=(i.status==='belum'||i.status==='ditolak')?'font-weight:600;':'';
      var tarikh=i.tarikh_bayar?'<td>'+formatTarikh(i.tarikh_bayar)+'</td>':'<td style="color:var(--tx3);">–</td>';
      return '<tr><td style="'+tebal+'">'+esc(i.bulan)+'</td><td>'+esc(i.pakej)+'</td><td style="'+tebal+'">'+rm2(i.jumlah)+'</td>'+tarikh+'<td><span class="badge '+st.badge+'">'+st.teks+'</span></td></tr>';
    }).join(''):'<tr><td colspan="5" style="text-align:center;color:var(--tx3);padding:24px;">Tiada rekod pembayaran.</td></tr>';
    refreshAtletInvois();
  }catch(error){
    tbody.innerHTML='<tr><td colspan="5" style="text-align:center;padding:24px;">Data gagal dimuatkan. Sila cuba lagi.</td></tr>';
    ralat(error);
  }
}
function pilihFailBukti(){
  var d=INVOIS_BULAN_DATA[document.getElementById('bayar-bulan').value];
  if(!d){toast('Tiada invois untuk dibayar.');return;}
  if(d.kod==='sudah'){toast('Invois ini telah disahkan. Tiada bayaran diperlukan.');return;}
  document.getElementById('bukti-input').click();
}
async function muatNaikBukti(pembayaranId,fail){
  if(!fail)return false;
  if(fail.size>5*1024*1024){toast('Gagal muat naik. Saiz fail melebihi 5MB.');return false;}
  var fd=new FormData();
  fd.append('pembayaran_id',pembayaranId);
  fd.append('bukti',fail);
  try{
    var res=await api('api/upload-bukti.php',{method:'POST',body:fd});
    toast(res.message);
    return true;
  }catch(error){ralat(error,'Gagal muat naik. Tidak dapat menghubungi server.');return false;}
}
async function hantarBukti(input){
  var d=INVOIS_BULAN_DATA[document.getElementById('bayar-bulan').value];
  var fail=input.files[0];
  input.value='';
  if(!d||!fail)return;
  if(await muatNaikBukti(d.id,fail))muatkanPembayaranAtlet();
}
function lihatBuktiSaya(){
  var d=INVOIS_BULAN_DATA[document.getElementById('bayar-bulan').value];
  if(d)lihatBukti(d.id);
}
async function padamBuktiSaya(){
  var d=INVOIS_BULAN_DATA[document.getElementById('bayar-bulan').value];
  if(!d)return;
  if(d.pertama){document.getElementById('bukti-input').click();return;}
  try{
    var res=await postJson('api/padam-bukti.php',{pembayaran_id:d.id});
    toast(res.message);
    muatkanPembayaranAtlet();
  }catch(error){ralat(error);}
}

/* ── Pendaftaran (carta alir atlet, Rajah 32) ── */
var DAFTAR_INVOIS=null;
function dataDaftar(){
  var nilai=function(id){return (document.getElementById(id).value||'').trim();};
  return {
    email:nilai('daftar-email'),kata_laluan:document.getElementById('daftar-pass').value||'',
    kata_laluan_sahkan:document.getElementById('daftar-pass-sahkan').value||'',
    pakej:document.getElementById('daftarPakej').value,nama:nilai('daftar-nama'),no_kp:nilai('daftar-kp'),
    tarikh_lahir:document.getElementById('daftar-tarikhlahir').value,
    nama_waris:nilai('daftar-namapenjaga'),no_telefon_waris:nilai('daftar-telpenjaga'),
    emel_waris:nilai('daftar-emelpenjaga'),sekolah:nilai('daftar-sekolah'),
    sesi:document.getElementById('daftarSesi').value
  };
}
// Setiap langkah disemak oleh pelayan sebelum ke langkah seterusnya.
async function semakLangkahDaftar(langkah){
  var seterusnya={akaun:'p-daftar2',atlet:'p-daftar3',waris:'p-bersetuju'}[langkah];
  var data=dataDaftar();
  data.semak=langkah;
  try{
    await postJson('api/daftar.php',data);
    if(langkah==='atlet')updateDaftarSesi();
    go(seterusnya);
  }catch(error){ralat(error,'Pendaftaran tidak berjaya. Sila cuba lagi.');}
}
var PERSETUJUAN=true;
function pilihPersetujuan(setuju){
  PERSETUJUAN=setuju;
  [['r-agree',setuju],['r-disagree',!setuju]].forEach(function(x){
    var bulat=document.querySelector('#'+x[0]+' .radio-bulat');
    document.getElementById(x[0]).classList.toggle('on',x[1]);
    bulat.style.borderColor=x[1]?'var(--pri)':'var(--border-d)';
    bulat.style.background=x[1]?'var(--pri)':'var(--surface)';
  });
}
function teruskanPersetujuan(){
  if(!PERSETUJUAN){toast('Anda perlu bersetuju untuk mengambil bahagian bagi meneruskan pendaftaran.');return;}
  go('p-deklarasi');
}
// Pakej baharu yang ditambah admin turut dipaparkan dalam borang pendaftaran.
async function muatPakejDaftar(){
  try{
    var senarai=await muatPakejSenarai();
    var sel=document.getElementById('daftarPakej');
    var ada=Array.from(sel.options).map(function(o){return 'Pakej '+o.value;});
    senarai.forEach(function(p){
      if(ada.indexOf(p.nama_pakej)<0){
        sel.add(new Option(p.nama_pakej+' ('+(p.sukan||'')+', '+(p.hari||'')+') — '+rm0(p.harga)+'/bln',p.nama_pakej));
        ada.push(p.nama_pakej);
      }
    });
  }catch(error){console.error(error);}
}
async function daftarAction(){
  var setuju=document.getElementById('deklarasi-setuju');
  if(!setuju || !setuju.checked){toast('Sila tandakan persetujuan terma dan syarat.');return;}
  var button=document.querySelector('#p-deklarasi button.btn-dark');
  if(button)button.disabled=true;
  try{
    var result=await postJson('api/daftar.php',dataDaftar());
    SESI={id:result.data.id,nama:result.data.nama,peranan:'atlet',invois_daftar:result.data.invois_daftar};
    DAFTAR_INVOIS=result.data.invois_daftar;
    ['daftar-pass','daftar-pass-sahkan'].forEach(function(i){document.getElementById(i).value='';});
    toast('Pendaftaran berjaya disimpan!');
    go('p-invois');
  }catch(error){
    ralat(error,'Pendaftaran tidak berjaya. Sila cuba lagi.');
  }finally{
    if(button)button.disabled=false;
  }
}
function paparInvoisPendaftaran(){
  var i=DAFTAR_INVOIS;
  if(!i)return;
  document.getElementById('daftar-inv-no').textContent=i.no;
  document.getElementById('daftar-inv-nama').textContent=i.nama;
  document.getElementById('daftar-inv-pakej').textContent=i.pakej;
  document.getElementById('daftar-inv-baju').textContent=rm2(i.baju);
  document.getElementById('daftar-inv-yuran').textContent=rm2(i.yuran);
  document.getElementById('daftar-inv-tarikh').textContent=formatTarikh(i.tarikh_akhir);
  document.getElementById('daftar-inv-jumlah').textContent=rm2(i.jumlah);
  var badge=document.querySelector('#p-invois .inv-head .badge');
  badge.textContent=i.status==='ditolak'?'Bukti Ditolak':'Belum Bayar';
  badge.className='badge '+(i.status==='ditolak'?'badge-danger':'badge-warning');
}
async function hantarBuktiPendaftaran(input){
  var fail=input.files[0];
  input.value='';
  if(!fail)return;
  if(!DAFTAR_INVOIS||!SESI){toast('Sila log masuk untuk memuat naik bukti pembayaran.');go('p-login');return;}
  if(await muatNaikBukti(DAFTAR_INVOIS.id,fail)){
    SESI.invois_daftar=null;
    DAFTAR_INVOIS=null;
    toast('Bukti pembayaran dimuat naik. Pendaftaran anda sedang diproses.');
    setTimeout(()=>go('p-dash-atlet'),1600);
  }
}

/* ── Log masuk / log keluar ── */
async function loginAction() {
  var seg = document.querySelector('.seg-btn.on');
  var peranan = seg && seg.id === 'seg-admin' ? 'admin' : 'atlet';

  var noKP = (document.getElementById('login-kp').value || '').trim();
  var password = document.getElementById('login-pass').value || '';

  if (!noKP || !password) {
    toast(peranan === 'admin' ? 'Sila masukkan e-mel dan kata laluan.' : 'Sila masukkan No. Kad Pengenalan dan kata laluan.');
    return;
  }

  var button = document.querySelector('#p-login button.btn-dark');
  if (button) button.disabled = true;

  try {
    var response = await fetch('api/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        no_kp: noKP,
        password: password,
        peranan: peranan
      })
    });

    var result = await response.json();

    if (!response.ok || !result.success) {
      toast(result.message || 'Log masuk gagal. Sila semak maklumat anda.');
      return;
    }

    SESI = result.data;
    document.getElementById('login-pass').value = '';
    toast('Log masuk berjaya!');

    if (peranan === 'admin') {
      go('p-dash-admin');
    } else {
      go('p-dash-atlet');
    }

  } catch (error) {
    console.error(error);
    toast('Tidak dapat menghubungi server. Pastikan Apache dan MySQL berjalan.');
  } finally {
    if (button) button.disabled = false;
  }
}
function setSeg(r) {
  document.getElementById('seg-atlet').classList.toggle('on', r === 'atlet');
  document.getElementById('seg-admin').classList.toggle('on', r === 'admin');

  var label = document.querySelector('#p-login .fg label');
  var input = document.getElementById('login-kp');

  if (r === 'admin') {
    label.innerHTML = 'E-mel<span class="req">*</span>';
    input.placeholder = 'Masukkan e-mel Admin';
    input.type = 'email';
  } else {
    label.innerHTML = 'No. Kad Pengenalan<span class="req">*</span>';
    input.placeholder = 'Contoh: 010101-01-0101';
    input.type = 'text';
  }
}
// Carta alir: lupa kata laluan -> masukkan e-mel berdaftar -> terima kata laluan baharu.
async function lupaKataLaluan(){
  var email=(document.getElementById('lupa-email').value||'').trim();
  if(!email){toast('Sila masukkan alamat e-mel berdaftar.');return;}
  var button=document.querySelector('#p-lupa button.btn-dark');
  if(button)button.disabled=true;
  try{
    var res=await postJson('api/lupa-kata-laluan.php',{email:email});
    toast(res.message);
    document.getElementById('lupa-email').value='';
    setTimeout(function(){go('p-login');},2200);
  }catch(error){ralat(error);}
  finally{if(button)button.disabled=false;}
}
async function logoutAction() {
  // Logo dan "Kembali" pada halaman awam juga memanggil fungsi ini: jika belum log masuk, terus ke laman utama.
  if (!SESI) {
    go('p-landing');
    return;
  }

  try {
    const response = await fetch('api/logout.php', {
      method: 'POST'
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      toast('Log keluar gagal. Sila cuba lagi.');
      return;
    }

    // Muat semula halaman supaya tiada data pengguna sebelumnya kekal dalam paparan.
    SESI = null;
    simpanStorage('at_halaman', null);
    simpanStorage('at_toast', 'Log keluar berjaya!');
    location.reload();

  } catch (error) {
    console.error(error);
    toast('Tidak dapat menghubungi server. Sila cuba lagi.');
  }
}

/* ── Profil atlet ── */
async function muatkanProfilAtlet() {
  try {
    const response = await fetch('api/profil-atlet.php');
    const result = await response.json();

    if (!response.ok || !result.success) {
      toast(result.message || 'Maklumat profil gagal dimuatkan.');
      return;
    }

    const atlet = result.data;

    document.getElementById('profil-atlet-kp').value =
      atlet.no_kp || '';

    document.getElementById('profil-atlet-tarikhlahir').value =
      atlet.tarikh_lahir || '';

    document.getElementById('profil-atlet-pakej').value =
      atlet.pakej || '';

    document.getElementById('profil-atlet-sesi').value =
      atlet.sesi || '';

    document.getElementById('profil-atlet-nama').value =
      atlet.nama || '';

    document.getElementById('profil-atlet-telwaris').value =
      atlet.no_telefon_waris || '';

    document.getElementById('profil-atlet-namawaris').value =
      atlet.nama_waris || '';

    document.getElementById('profil-atlet-sekolah').value =
      atlet.sekolah || '';

    document.getElementById('profil-atlet-emel').value =
      atlet.email || '';

    ['profil-atlet-pass-lama','profil-atlet-pass-baru','profil-atlet-pass-sahkan'].forEach(function(i){document.getElementById(i).value='';});

  } catch (error) {
    console.error(error);
    toast('Tidak dapat memuatkan profil atlet.');
  }
}
// Paparan halaman "Profil Saya" atlet.
async function muatkanHalamanProfilAtlet(){
  try{
    var a=(await api('api/profil-atlet.php')).data;
    var isi=function(id,v){document.getElementById(id).textContent=(v===null||v===undefined||v==='')?'-':v;};
    document.getElementById('atlet-avatar').textContent=inisial(a.nama);
    isi('atlet-nama',a.nama);
    isi('atlet-nama-penuh',a.nama);
    isi('atlet-no-kp',a.no_kp);
    isi('atlet-tarikh-lahir',a.tarikh_lahir?formatTarikh(a.tarikh_lahir):'');
    isi('atlet-pakej',a.pakej);
    isi('atlet-sesi',a.sesi);
    isi('atlet-nama-waris',a.nama_waris);
    isi('atlet-tel-waris',a.no_telefon_waris);
    isi('atlet-emel',a.email);
    isi('atlet-sekolah',a.sekolah);
    // Kategori atlet mengikut resit yuran pendaftaran dan tempoh pendaftaran.
    var badge=document.querySelector('#p-profil-atlet .profile-hd .badge');
    var kat=KATEGORI_ATLET[a.kategori]||KATEGORI_ATLET.belum;
    badge.textContent=kat.teks;
    badge.className='badge '+kat.badge;
  }catch(error){ralat(error,'Maklumat profil gagal dimuatkan.');}
}
var ADMIN_PROFIL=null;
async function muatkanProfilAdmin() {
    try {
        const response = await fetch('api/profil-admin.php', {
            method: 'GET',
            credentials: 'same-origin'
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            console.error('Gagal memuatkan profil admin:', result.message);
            return;
        }

        const admin = result.data;
        ADMIN_PROFIL = admin;

        const isi = function(id, nilai) {
            const el = document.getElementById(id);
            if (el) el.textContent = nilai || '-';
        };

        isi('admin-nama', admin.nama);
        isi('admin-nama-penuh', admin.nama);
        isi('admin-no-kp', admin.no_kp);
        isi('admin-tarikh-lahir', admin.tarikh_lahir ? formatTarikh(admin.tarikh_lahir) : '');
        isi('admin-no-telefon', admin.telefon);
        isi('admin-emel', admin.email);

        const avatarElement = document.getElementById('admin-avatar');
        if (avatarElement) {
            avatarElement.textContent = inisial(admin.nama || 'AD');
        }

    } catch (error) {
        console.error('Ralat memuatkan profil admin:', error);
    }
}
async function isiModalProfilAdmin(){
  if(!ADMIN_PROFIL)await muatkanProfilAdmin();
  var a=ADMIN_PROFIL||{};
  document.getElementById('profil-admin-kp').value=a.no_kp||'';
  document.getElementById('profil-admin-tarikhlahir').value=a.tarikh_lahir||'';
  document.getElementById('profil-admin-nama').value=a.nama||'';
  document.getElementById('profil-admin-tel').value=a.telefon||'';
  document.getElementById('profil-admin-emel').value=a.email||'';
  ['profil-admin-pass-lama','profil-admin-pass-baru','profil-admin-pass-sahkan'].forEach(function(i){document.getElementById(i).value='';});
}
async function simpanProfilAdmin(){
  var data={
    nama:document.getElementById('profil-admin-nama').value.trim(),
    no_kp:document.getElementById('profil-admin-kp').value.trim(),
    tarikh_lahir:document.getElementById('profil-admin-tarikhlahir').value,
    telefon:document.getElementById('profil-admin-tel').value.trim(),
    email:document.getElementById('profil-admin-emel').value.trim(),
    pass_lama:document.getElementById('profil-admin-pass-lama').value,
    pass_baru:document.getElementById('profil-admin-pass-baru').value,
    pass_sahkan:document.getElementById('profil-admin-pass-sahkan').value
  };
  if(!data.nama||!data.email){toast('Gagal kemaskini maklumat. Sila lengkapkan nama dan e-mel.');return;}
  try{
    var res=await postJson('api/kemaskini-profil-admin.php',data);
    ADMIN_PROFIL=null;
    SESI.nama=data.nama;
    paparNamaPengguna();
    closeModal('modal-kemaskini-admin-profil');
    toast(res.message);
    muatkanProfilAdmin();
  }catch(error){ralat(error);}
}
async function simpanProfilAtlet() {
  const nama = document.getElementById('profil-atlet-nama').value.trim();
  const telefon = document.getElementById('profil-atlet-telwaris').value.trim();
  const email = document.getElementById('profil-atlet-emel').value.trim();
  const namaWaris = document.getElementById('profil-atlet-namawaris').value.trim();
  const sekolah = document.getElementById('profil-atlet-sekolah').value.trim();

  const passLama = document.getElementById('profil-atlet-pass-lama').value;
  const passBaru = document.getElementById('profil-atlet-pass-baru').value;
  const passSahkan = document.getElementById('profil-atlet-pass-sahkan').value;

  if (!nama || !namaWaris || !telefon || !email) {
    toast('Gagal kemaskini maklumat. Sila lengkapkan nama, nama ibu/bapa, telefon waris dan e-mel.');
    return;
  }

  if ((passLama || passBaru || passSahkan) && passBaru !== passSahkan) {
    toast('Gagal kemaskini kata laluan. Pengesahan kata laluan baharu tidak sama.');
    return;
  }

  try {
    const response = await fetch('api/kemaskini-profil.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        nama: nama,
        no_telefon_waris: telefon,
        email: email,
        nama_waris: namaWaris,
        sekolah: sekolah,
        pass_lama: passLama,
        pass_baru: passBaru,
        pass_sahkan: passSahkan
      })
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      toast(result.message || 'Gagal kemaskini maklumat.');
      return;
    }

    toast(result.message || 'Profil berjaya dikemaskini!');
    closeModal('modal-kemaskini-atlet-profil');
    SESI.nama = nama;
    paparNamaPengguna();
    muatkanHalamanProfilAtlet();

  } catch (error) {
    console.error(error);
    toast('Tidak dapat menghubungi server. Sila cuba lagi.');
  }
}

/* ── Pengurusan atlet (admin) ── */
async function simpanKemaskiniAtlet() {
  const nama = document.getElementById('m-atlet-nama').value.trim();
  const noKP = document.getElementById('m-atlet-kp').value.trim();
  const tarikhLahir = document.getElementById('m-atlet-tarikhlahir').value;
  const pakej = document.getElementById('m-atlet-pakej').value;
  const sesi = document.getElementById('m-atlet-sesi').value;
  const telefon = document.getElementById('m-atlet-telwaris').value.trim();
  const email = document.getElementById('m-atlet-emel').value.trim();

  if (!nama || !noKP || !tarikhLahir || !pakej || !sesi || !telefon || !email) {
    toast('Gagal kemaskini maklumat. Sila lengkapkan semua maklumat.');
    return;
  }

  try {
    const response = await fetch('api/kemaskini-atlet.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        id: atletUntukDikemaskini,
        nama: nama,
        no_kp: noKP,
        tarikh_lahir: tarikhLahir,
        pakej: pakej,
        sesi: sesi,
        no_telefon_waris: telefon,
        email: email
      })
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      toast(result.message || 'Gagal kemaskini maklumat.');
      return;
    }

    closeModal('modal-kemaskini-atlet');
    toast('Maklumat atlet berjaya dikemaskini!');

    await loadAtlet();

  } catch (error) {
    console.error(error);
    toast('Tidak dapat menghubungi server. Sila cuba lagi.');
  }
}

function openModal(id) {
  document.getElementById(id).classList.add('open');

  if (id === 'modal-kemaskini-atlet-profil') {
    muatkanProfilAtlet();
  } else if (id === 'modal-kemaskini-admin-profil') {
    isiModalProfilAdmin();
  } else if (id === 'modal-tambah-pakej') {
    ['m-pakej-nama','m-pakej-sukan','m-pakej-hari','m-pakej-yuran','m-pakej-poster'].forEach(function(i){document.getElementById(i).value='';});
  } else if (id === 'modal-tambah-prestasi') {
    sediaModalPrestasi();
  } else if (id === 'modal-tambah-jurulatih') {
    ['nama','kp','tarikhlahir','tel','emel','namawaris','telwaris','emelwaris'].forEach(function(f){document.getElementById('m-jurulatih-'+f).value='';});
  }
}
function closeModal(id){document.getElementById(id).classList.remove('open');}
document.querySelectorAll('.modal-bg').forEach(m=>{m.onclick=function(e){if(e.target===this)this.classList.remove('open');};});
var toastT;
function toast(msg){var t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');clearTimeout(toastT);toastT=setTimeout(()=>t.classList.remove('show'),Math.max(2200,String(msg).length*60));}

/* ── Padam (modal dikongsi oleh semua modul) ── */
var PADAM_SASARAN=null; // {jenis, id}
function pilihPadam(jenis,id){PADAM_SASARAN={jenis:jenis,id:id};openModal('modal-padam');}
async function sahkanPadam(){
  if(!PADAM_SASARAN){toast('Sila pilih rekod yang hendak dipadam.');return;}
  var s=PADAM_SASARAN;
  if(s.jenis==='atlet'){await padamAtlet();return;}
  try{
    var res;
    if(s.jenis==='pakej'){
      var fd=new FormData();fd.append('aksi','padam');fd.append('id',s.id);
      res=await api('api/pakej.php',{method:'POST',body:fd});
      loadPakej();
    }else if(s.jenis==='jurulatih'){
      res=await postJson('api/jurulatih.php',{aksi:'padam',id:s.id});
      loadJurulatih();
    }else if(s.jenis==='prestasi'){
      res=await postJson('api/prestasi.php',{aksi:'padam',id:s.id});
      loadPrestasi();
    }else if(s.jenis==='hadir'){
      res=await postJson('api/mark-hadir.php',{tarikh:s.id.tarikh,rekod:[{atlet_id:s.id.atlet_id,status:''}]});
      res.message='Rekod kehadiran berjaya dipadam.';
      loadHadir();
    }
    closeModal('modal-padam');
    PADAM_SASARAN=null;
    toast(res.message);
  }catch(error){ralat(error);}
}

/* ── Kehadiran (admin) ── */
var HADIR_STATE=[];
var HADIR_ROWS=[];
function hadirBadge(status){return status==='hadir'?'<span class="badge badge-success">Hadir</span>':status==='tidak'?'<span class="badge badge-danger">Tidak Hadir</span>':'<span class="badge badge-default">Belum Ditanda</span>';}
function markHadir(el,i,status){
  var tr=el.closest('tr');
  var nxt=HADIR_STATE[i]===status?'':status;
  HADIR_STATE[i]=nxt;
  tr.querySelector('.hadir-btn').classList.toggle('on',nxt==='hadir');
  tr.querySelector('.tidak-btn').classList.toggle('on',nxt==='tidak');
  var sc=tr.querySelector('.st-cell');
  if(sc)sc.innerHTML=hadirBadge(nxt);
  updateCount();
}
function tickAll(){var rows=document.querySelectorAll('#hadir-tbody tr[data-i]');rows.forEach(function(tr){if(tr.style.display==='none')return;var i=+tr.dataset.i;tr.querySelector('.hadir-btn').classList.add('on');tr.querySelector('.tidak-btn').classList.remove('on');HADIR_STATE[i]='hadir';var sc=tr.querySelector('.st-cell');if(sc)sc.innerHTML=hadirBadge('hadir');});updateCount();}
function updateCount(){
  var rows=document.querySelectorAll('#hadir-tbody tr[data-i]');
  var visible=0,present=0;
  rows.forEach(function(tr){
    if(tr.style.display==='none')return;
    visible++;
    if(HADIR_STATE[+tr.dataset.i]==='hadir')present++;
  });
  var el=document.getElementById('hadir-count');if(el)el.textContent=present;
  var totalEl=document.getElementById('hadir-total');if(totalEl)totalEl.textContent=visible;
}
function filterHadir(){
  var pk=document.getElementById('hadir-pakej-filter').value;
  var ss=document.getElementById('hadir-sesi-filter').value;
  document.querySelectorAll('#hadir-tbody tr[data-i]').forEach(function(tr){
    var okPakej=pk==='Semua Pakej'||tr.dataset.pakej===pk;
    var okSesi=ss==='Semua Sesi'||tr.dataset.sesi.indexOf(ss)===0;
    tr.style.display=(okPakej&&okSesi)?'':'none';
  });
  updateCount();
}
function setHadirView(v){
  document.getElementById('seg-hadir-tanda').classList.toggle('on',v==='tanda');
  document.getElementById('seg-hadir-laporan').classList.toggle('on',v==='laporan');
  document.getElementById('hadir-view-tanda').style.display=v==='tanda'?'':'none';
  document.getElementById('hadir-view-laporan').style.display=v==='laporan'?'':'none';
  if(v==='laporan'){segarLaporan();}
}
function setLaporanView(v){
  document.getElementById('seg-laporan-individu').classList.toggle('on',v==='individu');
  document.getElementById('seg-laporan-keseluruhan').classList.toggle('on',v==='keseluruhan');
  document.getElementById('laporan-view-individu').style.display=v==='individu'?'':'none';
  document.getElementById('laporan-view-keseluruhan').style.display=v==='keseluruhan'?'':'none';
}
function loadHadirHalaman(){
  // Dibuka pada tarikh hari ini; tarikh lepas boleh dipilih, tarikh akan datang tidak.
  var t=document.getElementById('hadir-tarikh');
  t.value=tarikhHariIni();
  t.max=tarikhHariIni();
  document.getElementById('m-hadir-tarikh').max=tarikhHariIni();
  sediaBulanLaporan();
  loadHadir();
  if(document.getElementById('hadir-view-laporan').style.display!=='none')segarLaporan();
}
async function loadHadir(){
  var tbody=document.getElementById('hadir-tbody');
  var tarikh=document.getElementById('hadir-tarikh').value;
  if(!tarikh){toast('Sila pilih tarikh latihan.');return;}
  try{
    var d=(await api('api/get-hadir.php?tarikh='+encodeURIComponent(tarikh))).data;
    HADIR_ROWS=d.atlet;
    HADIR_STATE=d.atlet.map(function(a){return a.status||'';});
    tbody.innerHTML=d.atlet.length?d.atlet.map(function(a,i){
      var pct=a.peratus,warna=pctColor(pct),kelas=pct==null?'':pct>=80?'':pct>=60?'warn':'danger';
      return '<tr data-i="'+i+'" data-pakej="'+esc(a.pakej)+'" data-sesi="'+esc(a.sesi||'')+'">'+
        '<td style="font-weight:500;">'+esc(a.nama)+'</td><td>'+esc(a.pakej)+'</td>'+
        '<td style="text-align:center;"><span class="tick2 hadir-btn'+(a.status==='hadir'?' on':'')+'" onclick="markHadir(this,'+i+',\'hadir\')">✓</span><span class="tick2 tidak-btn'+(a.status==='tidak'?' on':'')+'" onclick="markHadir(this,'+i+',\'tidak\')">✗</span></td>'+
        '<td style="text-align:center;"><div style="font-weight:600;color:'+warna+';margin-bottom:4px;">'+(pct==null?'–':pct+'%')+'</div>'+
        '<div class="prog-wrap" style="width:80px;margin:0 auto;"><div class="prog '+kelas+'" style="width:'+(pct||0)+'%;"></div></div></td>'+
        '<td style="text-align:center;" class="st-cell">'+hadirBadge(a.status)+'</td>'+
        '<td><button class="ic-btn" style="color:var(--pri-d)" onclick="bukaKemaskiniHadir('+i+')">✎</button><button class="ic-btn" style="color:var(--rd)" onclick="padamHadir('+i+')">🗑</button></td></tr>';
    }).join(''):'<tr><td colspan="6" style="text-align:center;color:var(--tx3);padding:24px;">Tiada atlet berdaftar.</td></tr>';
    filterHadir();
  }catch(error){
    tbody.innerHTML='<tr><td colspan="6" style="text-align:center;padding:24px;">Data gagal dimuatkan. Sila cuba lagi.</td></tr>';
    ralat(error);
  }
}
async function simpanKehadiran(){
  var tarikh=document.getElementById('hadir-tarikh').value;
  if(!tarikh){toast('Sila pilih tarikh latihan.');return;}
  if(!HADIR_ROWS.length){toast('Tiada atlet untuk ditanda.');return;}
  try{
    var res=await postJson('api/mark-hadir.php',{tarikh:tarikh,rekod:HADIR_ROWS.map(function(a,i){return {atlet_id:a.id,status:HADIR_STATE[i]||''};})});
    toast(res.message);
    loadHadir();
  }catch(error){ralat(error);}
}
function bukaKemaskiniHadir(i){
  var a=HADIR_ROWS[i];
  var sel=document.getElementById('m-hadir-atlet');
  sel.innerHTML=HADIR_ROWS.map(function(x){return '<option value="'+x.id+'">'+esc(x.nama)+'</option>';}).join('');
  sel.value=a.id;
  document.getElementById('m-hadir-tarikh').value=document.getElementById('hadir-tarikh').value;
  document.getElementById('m-hadir-status').value=HADIR_STATE[i]==='tidak'?'Tidak Hadir':'Hadir';
  openModal('modal-kemaskini-hadir');
}
async function simpanKemaskiniHadir(){
  var atletId=document.getElementById('m-hadir-atlet').value;
  var tarikh=document.getElementById('m-hadir-tarikh').value;
  var status=document.getElementById('m-hadir-status').value==='Tidak Hadir'?'tidak':'hadir';
  if(!atletId||!tarikh){toast('Gagal kemaskini maklumat. Sila lengkapkan atlet dan tarikh.');return;}
  try{
    var res=await postJson('api/mark-hadir.php',{tarikh:tarikh,rekod:[{atlet_id:+atletId,status:status}]});
    closeModal('modal-kemaskini-hadir');
    toast(res.message);
    loadHadir();
  }catch(error){ralat(error);}
}
function padamHadir(i){
  if(!HADIR_STATE[i]){toast('Tiada rekod kehadiran untuk dipadam pada tarikh ini.');return;}
  pilihPadam('hadir',{atlet_id:HADIR_ROWS[i].id,tarikh:document.getElementById('hadir-tarikh').value});
}
var HADIR_PAKEJ={};   // id atlet -> pakej
var HADIR_NAMA={};    // id atlet -> nama
var HADIR_LOG={};     // id atlet -> {tarikh: status}
var BULAN_MS=['Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'];
var BULAN_PENDEK=['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogos','Sep','Okt','Nov','Dis'];
function formatTarikh(d){if(!d)return '-';var p=String(d).slice(0,10).split('-');return parseInt(p[2],10)+' '+BULAN_MS[parseInt(p[1],10)-1]+' '+p[0];}
function hadirStatusBadge(s){return s==='hadir'?'<span class="badge badge-success">Hadir</span>':'<span class="badge badge-danger">Tidak Hadir</span>';}
function computeHadirStats(athlete,dari,hingga){
  var log=HADIR_LOG[athlete]||{};
  var dates=Object.keys(log).filter(function(d){return d>=dari&&d<=hingga;}).sort();
  var hadir=0,tidak=0;
  dates.forEach(function(d){if(log[d]==='hadir')hadir++;else tidak++;});
  var total=dates.length;
  var pct=total?Math.round(hadir/total*100):null;
  return {dates:dates,hadir:hadir,tidak:tidak,total:total,pct:pct};
}
function pctColor(pct){return pct==null?'var(--tx3)':pct>=80?'var(--gn)':pct>=60?'var(--am)':'var(--rd)';}
var LAPORAN_BULAN_RANGE={};
// Pilihan bulan laporan: bulan semasa (hingga hari ini) dan dua bulan sebelumnya.
function sediaBulanLaporan(){
  LAPORAN_BULAN_RANGE={};
  for(var o=0;o>=-2;o--){
    var kod=bulanSemasaKod(o),p=kod.split('-');
    var akhir=new Date(+p[0],+p[1],0).getDate();
    LAPORAN_BULAN_RANGE[namaBulanKod(kod)]=[kod+'-01',o===0?tarikhHariIni():kod+'-'+String(akhir).padStart(2,'0')];
  }
  var opts=Object.keys(LAPORAN_BULAN_RANGE).map(function(b){return '<option>'+b+'</option>';}).join('')+'<option value="custom">Julat Tersuai</option>';
  [['laporan-bulan-individu','laporan-dari','laporan-hingga'],['laporan-bulan-keseluruhan','laporan-k-dari','laporan-k-hingga']].forEach(function(x){
    var sel=document.getElementById(x[0]);
    if(sel.options.length>1)return; // sudah disediakan
    sel.innerHTML=opts;
    var r=LAPORAN_BULAN_RANGE[sel.value];
    document.getElementById(x[1]).value=r[0];
    document.getElementById(x[2]).value=r[1];
  });
}
// Muatkan rekod kehadiran bagi julat yang meliputi kedua-dua laporan, kemudian papar semula.
async function segarLaporan(){
  var tarikh=[document.getElementById('laporan-dari').value,document.getElementById('laporan-hingga').value,
              document.getElementById('laporan-k-dari').value,document.getElementById('laporan-k-hingga').value].filter(Boolean).sort();
  if(!tarikh.length)return;
  try{
    var d=(await api('api/get-hadir.php?dari='+tarikh[0]+'&hingga='+tarikh[tarikh.length-1])).data;
    HADIR_PAKEJ={};HADIR_NAMA={};HADIR_LOG={};
    d.atlet.forEach(function(a){HADIR_PAKEJ[a.id]=a.pakej;HADIR_NAMA[a.id]=a.nama;HADIR_LOG[a.id]={};});
    d.rekod.forEach(function(r){if(HADIR_LOG[r.atlet_id])HADIR_LOG[r.atlet_id][r.tarikh]=r.status;});
    onLaporanPakejIndividuChange();
    updateLaporanKeseluruhan();
  }catch(error){ralat(error);}
}
function setLaporanBulanIndividu(){
  var b=document.getElementById('laporan-bulan-individu').value;
  if(b==='custom')return;
  var r=LAPORAN_BULAN_RANGE[b];
  document.getElementById('laporan-dari').value=r[0];
  document.getElementById('laporan-hingga').value=r[1];
  segarLaporan();
}
function setLaporanCustomIndividu(){
  document.getElementById('laporan-bulan-individu').value='custom';
  segarLaporan();
}
function setLaporanBulanKeseluruhan(){
  var b=document.getElementById('laporan-bulan-keseluruhan').value;
  if(b==='custom')return;
  var r=LAPORAN_BULAN_RANGE[b];
  document.getElementById('laporan-k-dari').value=r[0];
  document.getElementById('laporan-k-hingga').value=r[1];
  segarLaporan();
}
function setLaporanCustomKeseluruhan(){
  document.getElementById('laporan-bulan-keseluruhan').value='custom';
  segarLaporan();
}
function onLaporanPakejIndividuChange(){
  var pk=document.getElementById('laporan-pakej-individu').value;
  var sel=document.getElementById('laporan-athlete');
  var dipilih=sel.value;
  var athletes=Object.keys(HADIR_PAKEJ).filter(function(a){return pk==='Semua Pakej'||HADIR_PAKEJ[a]===pk;});
  athletes.sort(function(x,y){return HADIR_NAMA[x].localeCompare(HADIR_NAMA[y]);});
  sel.innerHTML=athletes.map(function(a){return '<option value="'+a+'">'+esc(HADIR_NAMA[a])+'</option>';}).join('');
  if(athletes.indexOf(dipilih)>-1)sel.value=dipilih;
  updateLaporanIndividu();
}
function updateLaporanIndividu(){
  var athlete=document.getElementById('laporan-athlete').value;
  var dari=document.getElementById('laporan-dari').value;
  var hingga=document.getElementById('laporan-hingga').value;
  var statsEl=document.getElementById('laporan-individu-stats');
  var logEl=document.getElementById('laporan-individu-log');
  if(!athlete){statsEl.innerHTML='';logEl.innerHTML='<tr><td colspan="2" style="text-align:center;color:var(--tx3);padding:20px;">Tiada atlet.</td></tr>';return;}
  var s=computeHadirStats(athlete,dari,hingga);
  statsEl.innerHTML=
    '<div class="card card-body"><div class="metric-label" style="margin-bottom:6px;">Jumlah Sesi</div><div class="metric-val">'+s.total+'</div></div>'+
    '<div class="card card-body"><div class="metric-label" style="margin-bottom:6px;">Hadir</div><div class="metric-val" style="color:var(--gn);">'+s.hadir+'</div></div>'+
    '<div class="card card-body"><div class="metric-label" style="margin-bottom:6px;">Tidak Hadir</div><div class="metric-val" style="color:var(--rd);">'+s.tidak+'</div></div>'+
    '<div class="card card-body"><div class="metric-label" style="margin-bottom:6px;">Peratus Kehadiran</div><div class="metric-val" style="color:'+pctColor(s.pct)+';">'+(s.pct==null?'–':s.pct+'%')+'</div></div>';
  var log=HADIR_LOG[athlete]||{};
  logEl.innerHTML=s.dates.length?s.dates.map(function(d){
    return '<tr><td>'+formatTarikh(d)+'</td><td>'+hadirStatusBadge(log[d])+'</td></tr>';
  }).join(''):'<tr><td colspan="2" style="text-align:center;color:var(--tx3);padding:20px;">Tiada sesi dalam julat tarikh ini.</td></tr>';
}
function updateLaporanKeseluruhan(){
  var pk=document.getElementById('laporan-pakej-filter').value;
  var dari=document.getElementById('laporan-k-dari').value;
  var hingga=document.getElementById('laporan-k-hingga').value;
  var athletes=Object.keys(HADIR_PAKEJ).filter(function(a){return pk==='Semua Pakej'||HADIR_PAKEJ[a]===pk;});
  var rows=athletes.map(function(a){return {nama:HADIR_NAMA[a],pakej:HADIR_PAKEJ[a],s:computeHadirStats(a,dari,hingga)};});
  rows.sort(function(x,y){
    if(x.s.pct==null)return 1;
    if(y.s.pct==null)return -1;
    return y.s.pct-x.s.pct;
  });
  document.getElementById('laporan-keseluruhan-tbody').innerHTML=rows.length?rows.map(function(r,i){
    var pctTxt=r.s.pct==null?'<span style="color:var(--tx3);">–</span>':'<span style="font-weight:700;color:'+pctColor(r.s.pct)+';">'+r.s.pct+'%</span>';
    return '<tr><td style="font-weight:600;color:var(--pri-d);">#'+(i+1)+'</td><td style="font-weight:500;">'+esc(r.nama)+'</td><td>'+esc(r.pakej)+'</td><td style="text-align:center;">'+r.s.hadir+'</td><td style="text-align:center;">'+r.s.tidak+'</td><td style="text-align:center;">'+pctTxt+'</td></tr>';
  }).join(''):'<tr><td colspan="6" style="text-align:center;color:var(--tx3);padding:20px;">Tiada rekod.</td></tr>';
}

/* ── Report Preview / Print ── */
function showReportPreview(title,sub,bodyHtml){
  var tarikh=new Date().toLocaleDateString('ms-MY',{day:'2-digit',month:'long',year:'numeric'});
  document.getElementById('reportPrintArea').innerHTML=
    '<div class="report-letterhead"><h3>KELAB OLAHRAGA SHAH ALAM</h3><p>Kompleks Belia & Sukan Selangor, Shah Alam</p></div>'+
    '<p class="report-title">'+title+'</p>'+
    (sub?'<p class="report-sub">'+sub+'</p>':'')+
    '<div class="report-meta"><span>Dijana oleh: '+esc(SESI?SESI.nama:'-')+' (Admin)</span><span>Tarikh: '+tarikh+'</span></div>'+
    '<hr class="divider">'+
    bodyHtml;
  openModal('modal-laporan-preview');
}
function openReportAtlet(){
  var rows=Array.from(document.querySelectorAll('#atlet-tbody tr')).filter(function(tr){return tr.style.display!=='none'&&tr.querySelectorAll('td').length>=5;});
  var body='<table style="width:100%;border-collapse:collapse;font-size:12.5px;">'+
    '<thead><tr style="border-bottom:2px solid var(--tx);"><th style="text-align:left;padding:8px 6px;">Nama Atlet</th><th style="text-align:left;padding:8px 6px;">No. KP</th><th style="text-align:left;padding:8px 6px;">Pakej</th><th style="text-align:left;padding:8px 6px;">E-mel</th><th style="text-align:left;padding:8px 6px;">Status</th></tr></thead><tbody>'+
    rows.map(function(tr){
      var td=tr.querySelectorAll('td');
      return '<tr style="border-bottom:1px solid var(--border);">'+
        '<td style="padding:8px 6px;">'+esc(td[0].textContent.trim())+'</td>'+
        '<td style="padding:8px 6px;">'+esc(td[1].textContent.trim())+'</td>'+
        '<td style="padding:8px 6px;">'+esc(td[2].textContent.trim())+'</td>'+
        '<td style="padding:8px 6px;">'+esc(td[3].textContent.trim())+'</td>'+
        '<td style="padding:8px 6px;">'+esc(td[4].textContent.trim())+'</td></tr>';
    }).join('')+
    '</tbody></table>'+
    '<p style="font-size:11px;color:var(--tx3);margin-top:14px;">Jumlah rekod: '+rows.length+'</p>';
  showReportPreview('Senarai Atlet Berdaftar','Laporan penuh atlet mengikut pakej semasa',body);
}
function openReportPrestasi(){
  updatePrestasiIndividu();
  var athlete=document.getElementById('prestasi-athlete').value;
  if(!athlete){toast('Tiada atlet untuk dijana graf.');return;}
  var chart=document.getElementById('prestasi-bar-chart').innerHTML;
  var rows=PRESTASI_ACARA.map(function(acara){
    var d=dataPrestasi(athlete,acara),dp=PRESTASI_DP[acara];
    var change=prestasiChangeHtml(acara,d.lepas,d.ini);
    return '<tr><td style="padding:8px 6px;">'+acara+'</td><td style="padding:8px 6px;">'+(d.lepas!=null?d.lepas.toFixed(dp):'&ndash;')+'</td><td style="padding:8px 6px;">'+(d.ini!=null?d.ini.toFixed(dp):'&ndash;')+'</td><td style="padding:8px 6px;">'+change+'</td></tr>';
  }).join('');
  var body='<div class="bar-chart-diverge" style="border-bottom:1px solid var(--border);padding-bottom:18px;margin-bottom:18px;">'+chart+'</div>'+
    '<table style="width:100%;border-collapse:collapse;font-size:12.5px;">'+
    '<thead><tr style="border-bottom:2px solid var(--tx);"><th style="text-align:left;padding:8px 6px;">Acara</th><th style="text-align:left;padding:8px 6px;">Bulan Lepas</th><th style="text-align:left;padding:8px 6px;">Bulan Ini</th><th style="text-align:left;padding:8px 6px;">Perubahan</th></tr></thead>'+
    '<tbody>'+rows+'</tbody></table>';
  showReportPreview('Laporan Prestasi Individu',esc(PRESTASI_NAMA[athlete])+' &middot; Semua Acara',body);
}
function openReportHadirIndividu(){
  updateLaporanIndividu();
  var athlete=document.getElementById('laporan-athlete').value;
  var dari=document.getElementById('laporan-dari').value;
  var hingga=document.getElementById('laporan-hingga').value;
  var stats=document.getElementById('laporan-individu-stats').innerHTML;
  var log=document.getElementById('laporan-individu-log').innerHTML;
  var body='<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px;">'+stats+'</div>'+
    '<table style="width:100%;border-collapse:collapse;font-size:12.5px;">'+
    '<thead><tr style="border-bottom:2px solid var(--tx);"><th style="text-align:left;padding:8px 6px;">Tarikh</th><th style="text-align:left;padding:8px 6px;">Status</th></tr></thead>'+
    '<tbody>'+log+'</tbody></table>';
  showReportPreview('Laporan Kehadiran Individu',esc(HADIR_NAMA[athlete]||'-')+' &middot; '+formatTarikh(dari)+' &ndash; '+formatTarikh(hingga),body);
}
function openReportHadirKeseluruhan(){
  updateLaporanKeseluruhan();
  var pk=document.getElementById('laporan-pakej-filter').value;
  var dari=document.getElementById('laporan-k-dari').value;
  var hingga=document.getElementById('laporan-k-hingga').value;
  var rows=document.getElementById('laporan-keseluruhan-tbody').innerHTML;
  var body='<table style="width:100%;border-collapse:collapse;font-size:12.5px;">'+
    '<thead><tr style="border-bottom:2px solid var(--tx);"><th style="text-align:left;padding:8px 6px;">#</th><th style="text-align:left;padding:8px 6px;">Nama Atlet</th><th style="text-align:left;padding:8px 6px;">Pakej</th><th style="text-align:center;padding:8px 6px;">Hadir</th><th style="text-align:center;padding:8px 6px;">Tidak Hadir</th><th style="text-align:center;padding:8px 6px;">Peratus</th></tr></thead>'+
    '<tbody>'+rows+'</tbody></table>';
  showReportPreview('Laporan Kehadiran Keseluruhan',pk+' &middot; '+formatTarikh(dari)+' &ndash; '+formatTarikh(hingga),body);
}

function filterAtlet(){
  var q=(document.getElementById('atlet-search').value||'').toLowerCase();
  var pk=document.getElementById('atlet-pakej-filter').value;
  document.querySelectorAll('#atlet-tbody tr').forEach(function(tr){
    if(tr.children.length<3)return;
    var nama=tr.children[0].textContent.toLowerCase();
    var kp=tr.children[1].textContent.toLowerCase();
    var pakej=tr.children[2].textContent.trim();
    var match=(pk==='Semua Pakej'||pakej===pk)&&(nama.indexOf(q)>-1||kp.indexOf(q)>-1);
    tr.style.display=match?'':'none';
  });
}

/* ── Pembayaran (admin) ── */
var BAYAR_DIRTY=false;
function filterBayar(){
  var q=(document.getElementById('bayar-search').value||'').toLowerCase();
  var bln=document.getElementById('bayar-bulan-filter').value;
  var st=document.getElementById('bayar-status-filter').value;
  var pk=document.getElementById('bayar-pakej-filter').value;
  document.querySelectorAll('#bayar-tbody tr[data-id]').forEach(function(tr){
    var nama=tr.children[0].textContent.toLowerCase();
    var pakej=tr.children[2].textContent.trim();
    var bulanOk=(bln==='Semua Bulan'||tr.dataset.bulan===bln);
    var statusText=tr.querySelector('.pay-status').textContent.trim();
    var statusOk=(st==='Semua Status'||statusText===st);
    var pakejOk=(pk==='Semua Pakej'||pakej===pk);
    var searchOk=nama.indexOf(q)>-1;
    tr.style.display=(bulanOk&&statusOk&&pakejOk&&searchOk)?'':'none';
  });
  updateBayarCount();
}
function markBayar(el,status){
  var tr=el.closest('tr');
  var yesBtn=tr.querySelector('.hadir-btn');
  var noBtn=tr.querySelector('.tidak-btn');
  var current=yesBtn.classList.contains('on')?'sah':(noBtn.classList.contains('on')?'tolak':'');
  var next=current===status?'':status;
  yesBtn.classList.toggle('on',next==='sah');
  noBtn.classList.toggle('on',next==='tolak');
  var sc=tr.querySelector('.pay-status');
  if(sc)sc.innerHTML=next==='sah'?'<span class="badge badge-success">Disahkan</span>':next==='tolak'?'<span class="badge badge-danger">Ditolak</span>':'<span class="badge badge-warning">Menunggu</span>';
  if(next==='tolak'){
    toast('Bukti pembayaran akan ditolak. Atlet perlu memuat naik bukti baharu.');
  }else if(next==='sah'&&tr.dataset.newReg==='true'){
    toast('Pembayaran pendaftaran disahkan! Atlet kini aktif berdaftar.');
  }
  tr.dataset.status=next;
  BAYAR_DIRTY=true;
  updateBayarCount();
}
function updateBayarCount(){
  var confirmed=0,total=0;
  document.querySelectorAll('#bayar-tbody tr[data-id]').forEach(function(tr){
    if(tr.style.display==='none')return;
    total++;
    if(tr.querySelector('.pay-status').textContent.trim()==='Disahkan')confirmed++;
  });
  var el=document.getElementById('bayar-confirmed-count');
  if(el)el.textContent=confirmed;
  if(el&&el.nextSibling)el.nextSibling.textContent=' / '+total;
}
async function saveBayar(){
  var perubahan=Array.from(document.querySelectorAll('#bayar-tbody tr[data-id]'))
    .filter(function(tr){return tr.dataset.status!==tr.dataset.asal;})
    .map(function(tr){return {id:+tr.dataset.id,status:tr.dataset.status};});
  if(!BAYAR_DIRTY||!perubahan.length){toast('Tiada perubahan untuk disimpan.');return;}
  try{
    var res=await postJson('api/pembayaran-admin.php',{perubahan:perubahan});
    BAYAR_DIRTY=false;
    toast(res.message);
    loadBayarAdmin();
  }catch(error){ralat(error);}
}
async function loadBayarAdmin(){
  var tbody=document.getElementById('bayar-tbody');
  try{
    var j=await api('api/pembayaran-admin.php');
    var tick={sudah:'sah',ditolak:'tolak'};
    var label={belum:['Belum Ada Bukti','badge-danger'],menunggu_sahkan:['Menunggu','badge-warning'],sudah:['Disahkan','badge-success'],ditolak:['Ditolak','badge-danger']};
    tbody.innerHTML=j.data.length?j.data.map(function(p){
      var st=label[p.status]||label.belum,t=tick[p.status]||'';
      var baru=p.pendaftaran_baharu?' <span class="badge badge-info" style="font-size:9px;vertical-align:middle;">Pendaftaran Baharu</span>':'';
      var bukti=p.ada_bukti?'<td><a class="link" style="font-size:12.5px;" onclick="lihatBukti('+p.id+')">Lihat Bukti</a></td>':'<td style="color:var(--tx3);font-size:12.5px;">Belum dimuat naik</td>';
      var semak=p.ada_bukti?'<td style="text-align:center;"><span class="tick2 hadir-btn'+(t==='sah'?' on':'')+'" onclick="markBayar(this,\'sah\')" title="Sahkan pembayaran">✓</span><span class="tick2 tidak-btn'+(t==='tolak'?' on':'')+'" onclick="markBayar(this,\'tolak\')" title="Tolak pembayaran">✗</span></td>':'<td style="text-align:center;"><span style="color:var(--tx3);">–</span></td>';
      return '<tr data-id="'+p.id+'" data-kod="'+p.status+'" data-bulan="'+esc(p.bulan)+'" data-asal="'+t+'" data-status="'+t+'"'+(p.pendaftaran_baharu?' data-new-reg="true"':'')+'>'+
        '<td style="font-weight:500;">'+esc(p.nama)+baru+'</td><td>'+esc(p.bulan)+'</td><td>'+esc(p.pakej)+'</td><td style="font-weight:500;">'+rm2(p.jumlah)+'</td>'+
        bukti+'<td class="pay-status"><span class="badge '+st[1]+'">'+st[0]+'</span></td>'+semak+'</tr>';
    }).join(''):'<tr><td colspan="7" style="text-align:center;color:var(--tx3);padding:24px;">Tiada rekod pembayaran.</td></tr>';
    var sel=document.getElementById('bayar-bulan-filter');
    var dipilih=sel.value;
    var senaraiBulan=[];
    j.data.forEach(function(p){if(senaraiBulan.indexOf(p.bulan)<0)senaraiBulan.push(p.bulan);});
    sel.innerHTML=senaraiBulan.map(function(b){return '<option>'+esc(b)+'</option>';}).join('')+'<option>Semua Bulan</option>';
    // Kali pertama: papar bulan semasa (seperti reka bentuk asal); selepas itu kekalkan pilihan admin.
    if(!sel.dataset.sedia){dipilih=j.bulan_semasa;sel.dataset.sedia='1';}
    sel.value=senaraiBulan.indexOf(dipilih)>-1||dipilih==='Semua Bulan'?dipilih:'Semua Bulan';
    BAYAR_DIRTY=false;
    filterBayar();
  }catch(error){
    tbody.innerHTML='<tr><td colspan="7" style="text-align:center;padding:24px;">Data gagal dimuatkan. Sila cuba lagi.</td></tr>';
    ralat(error);
  }
}
// Admin menetapkan/menghantar peringatan bayaran kepada atlet yang belum bayar dalam senarai yang dipaparkan.
async function hantarPeringatan(){
  var id=Array.from(document.querySelectorAll('#bayar-tbody tr[data-id]'))
    .filter(function(tr){return tr.style.display!=='none'&&(tr.dataset.kod==='belum'||tr.dataset.kod==='ditolak');})
    .map(function(tr){return +tr.dataset.id;});
  if(!id.length){toast('Tiada atlet yang belum membayar dalam senarai yang dipaparkan.');return;}
  try{
    var res=await postJson('api/pembayaran-admin.php',{aksi:'peringatan',id:id});
    toast(res.message);
  }catch(error){ralat(error);}
}
function lihatBukti(id){window.open('api/lihat-bukti.php?id='+encodeURIComponent(id),'_blank');}

/* ── Prestasi (admin) ── */
var PRESTASI_ACARA=['Larian 100m (saat)','Lompat Jauh (m)','Lompat Tinggi (m)','Lontar Peluru (m)'];
var PRESTASI_LOWER_BETTER={'Larian 100m (saat)':true,'Lompat Jauh (m)':false,'Lompat Tinggi (m)':false,'Lontar Peluru (m)':false};
var PRESTASI_DP={'Larian 100m (saat)':1,'Lompat Jauh (m)':1,'Lompat Tinggi (m)':2,'Lontar Peluru (m)':1};
var PRESTASI_PAKEJ={};  // id atlet -> pakej
var PRESTASI_NAMA={};   // id atlet -> nama
var PRESTASI_DATA={};   // id atlet -> acara -> {lepas, ini, idLepas, idIni}
var PRESTASI_BULAN={ini:{kod:bulanSemasaKod(0),nama:namaBulanKod(bulanSemasaKod(0))},lepas:{kod:bulanSemasaKod(-1),nama:namaBulanKod(bulanSemasaKod(-1))}};
function dataPrestasi(athlete,acara){return (PRESTASI_DATA[athlete]&&PRESTASI_DATA[athlete][acara])||{lepas:null,ini:null};}
async function loadPrestasi(){
  try{
    var d=(await api('api/prestasi.php')).data;
    PRESTASI_BULAN={ini:d.bulan_ini,lepas:d.bulan_lepas};
    PRESTASI_PAKEJ={};PRESTASI_NAMA={};PRESTASI_DATA={};
    d.atlet.forEach(function(a){PRESTASI_PAKEJ[a.id]=a.pakej;PRESTASI_NAMA[a.id]=a.nama;PRESTASI_DATA[a.id]={};});
    d.rekod.forEach(function(r){
      if(!PRESTASI_DATA[r.atlet_id])return;
      var x=PRESTASI_DATA[r.atlet_id][r.acara]||(PRESTASI_DATA[r.atlet_id][r.acara]={lepas:null,ini:null});
      if(r.bulan===d.bulan_ini.kod){x.ini=r.markah;x.idIni=r.id;}else{x.lepas=r.markah;x.idLepas=r.id;}
    });
    document.querySelectorAll('.prestasi-bln-lepas').forEach(function(e){e.textContent='('+d.bulan_lepas.nama+')';});
    document.querySelectorAll('.prestasi-bln-ini').forEach(function(e){e.textContent='('+d.bulan_ini.nama+')';});
    document.getElementById('prestasi-top3-note').textContent='Menunjukkan 3 atlet terbaik bulan ini ('+d.bulan_ini.nama+')';
    var sel=document.getElementById('prestasi-athlete');
    var dipilih=sel.value;
    sel.innerHTML=d.atlet.map(function(a){return '<option value="'+a.id+'">'+esc(a.nama)+'</option>';}).join('');
    if(PRESTASI_NAMA[dipilih])sel.value=dipilih;
    updatePrestasiIndividu();
    updatePrestasiKeseluruhan();
  }catch(error){ralat(error);}
}
function prestasiActionBtns(acara){return '<td><button class="ic-btn" style="color:var(--pri-d)" onclick="bukaKemaskiniPrestasi(\''+acara+'\')">&#9998;</button><button class="ic-btn" style="color:var(--rd)" onclick="padamPrestasi(\''+acara+'\')">&#128465;</button></td>';}
function prestasiChangeHtml(acara,lepas,ini){
  if(lepas==null||ini==null)return '<span style="color:var(--tx3);font-weight:500;">Rekod pertama</span>';
  var lowerBetter=PRESTASI_LOWER_BETTER[acara];
  var pct=lowerBetter?((lepas-ini)/lepas*100):((ini-lepas)/lepas*100);
  var improved=pct>=0;
  var arrow=improved?'&#8593;':'&#8595;';
  var color=improved?'var(--gn)':'var(--rd)';
  return '<span style="color:'+color+';font-weight:700;">'+arrow+' '+(improved?'+':'')+pct.toFixed(1)+'%</span>';
}
function prestasiCell(v,dp,bold){
  if(v==null)return '<td style="text-align:center;color:var(--tx3);'+(bold?'font-weight:600;':'')+'">&ndash;</td>';
  return '<td style="text-align:center;'+(bold?'font-weight:600;':'')+'">'+v.toFixed(dp)+'</td>';
}
function setPrestasiView(v){
  document.getElementById('seg-prestasi-individu').classList.toggle('on',v==='individu');
  document.getElementById('seg-prestasi-keseluruhan').classList.toggle('on',v==='keseluruhan');
  document.getElementById('prestasi-view-individu').style.display=v==='individu'?'':'none';
  document.getElementById('prestasi-view-keseluruhan').style.display=v==='keseluruhan'?'':'none';
  if(v==='keseluruhan')updatePrestasiKeseluruhan();
}
function renderPrestasiIndividuTbl(){
  var athlete=document.getElementById('prestasi-athlete').value;
  var tbody=document.getElementById('prestasi-individu-tbody');
  if(!athlete){tbody.innerHTML='<tr><td colspan="5" style="text-align:center;color:var(--tx3);padding:24px;">Tiada atlet berdaftar.</td></tr>';return;}
  tbody.innerHTML=PRESTASI_ACARA.map(function(acara){
    var d=dataPrestasi(athlete,acara),dp=PRESTASI_DP[acara];
    var cells=prestasiCell(d.lepas,dp,false)+prestasiCell(d.ini,dp,true);
    var change=prestasiChangeHtml(acara,d.lepas,d.ini);
    return '<tr><td style="font-weight:500;">'+acara+'</td>'+cells+'<td style="text-align:center;">'+change+'</td>'+prestasiActionBtns(acara)+'</tr>';
  }).join('');
}
function prestasiPctVal(acara,lepas,ini){
  if(lepas==null||ini==null)return null;
  var lowerBetter=PRESTASI_LOWER_BETTER[acara];
  return lowerBetter?((lepas-ini)/lepas*100):((ini-lepas)/lepas*100);
}
function renderPrestasiGraf(){
  var athlete=document.getElementById('prestasi-athlete').value;
  if(!athlete){
    document.getElementById('prestasi-bar-chart').innerHTML='';
    document.getElementById('prestasi-graf-title').textContent='Graf Prestasi — Perubahan Semua Acara';
    return;
  }
  var results=PRESTASI_ACARA.map(function(acara){
    var d=dataPrestasi(athlete,acara);
    return {acara:acara,pct:prestasiPctVal(acara,d.lepas,d.ini)};
  });
  var maxAbs=results.reduce(function(m,r){return r.pct!=null?Math.max(m,Math.abs(r.pct)):m;},1);
  document.getElementById('prestasi-bar-chart').innerHTML=results.map(function(r){
    var lbl=r.acara.replace(' (','<br>(');
    if(r.pct==null){
      return '<div class="bdc-col"><div class="bdc-top"></div><div class="bdc-mid"></div><div class="bdc-bottom"><span class="bdc-val" style="color:var(--tx3);">Tiada rekod</span></div><div class="bdc-lbl">'+lbl+'</div></div>';
    }
    var h=Math.max(4,Math.round((Math.abs(r.pct)/maxAbs)*72));
    var color=r.pct>=0?'var(--gn)':'var(--rd)';
    var sign=r.pct>=0?'+':'';
    var valSpan='<span class="bdc-val" style="color:'+color+';">'+sign+r.pct.toFixed(1)+'%</span>';
    var barDiv='<div class="bdc-bar" style="height:'+h+'px;background:'+color+';"></div>';
    var top=r.pct>=0?(valSpan+barDiv):'';
    var bottom=r.pct<0?(barDiv+valSpan):'';
    return '<div class="bdc-col"><div class="bdc-top">'+top+'</div><div class="bdc-mid"></div><div class="bdc-bottom">'+bottom+'</div><div class="bdc-lbl">'+lbl+'</div></div>';
  }).join('');
  document.getElementById('prestasi-graf-title').textContent='Graf Prestasi — Perubahan Semua Acara · '+PRESTASI_NAMA[athlete];
}
function updatePrestasiIndividu(){renderPrestasiIndividuTbl();renderPrestasiGraf();}
function updatePrestasiKeseluruhan(){
  var acara=document.getElementById('prestasi-acara-filter').value;
  var dp=PRESTASI_DP[acara],lowerBetter=PRESTASI_LOWER_BETTER[acara];
  var pk=document.getElementById('prestasi-pakej-filter').value;
  var rows=Object.keys(PRESTASI_DATA).filter(function(a){return pk==='Semua Pakej'||PRESTASI_PAKEJ[a]===pk;}).map(function(a){
    var d=dataPrestasi(a,acara);
    return {nama:PRESTASI_NAMA[a],pakej:PRESTASI_PAKEJ[a],d:d};
  }).filter(function(r){return r.d.ini!=null;});
  rows.sort(function(x,y){
    return lowerBetter?(x.d.ini-y.d.ini):(y.d.ini-x.d.ini);
  });
  rows=rows.slice(0,3);
  document.getElementById('prestasi-keseluruhan-tbody').innerHTML=rows.length?rows.map(function(r,i){
    var cells=prestasiCell(r.d.lepas,dp,false)+prestasiCell(r.d.ini,dp,true);
    var change=prestasiChangeHtml(acara,r.d.lepas,r.d.ini);
    return '<tr><td style="font-weight:600;color:var(--pri-d);">#'+(i+1)+'</td><td style="font-weight:500;">'+esc(r.nama)+'</td><td>'+esc(r.pakej)+'</td>'+cells+'<td style="text-align:center;">'+change+'</td></tr>';
  }).join(''):'<tr><td colspan="6" style="text-align:center;color:var(--tx3);padding:24px;">Tiada rekod prestasi bulan ini untuk acara ini.</td></tr>';
}
function pilihanAtletPrestasi(){
  return Object.keys(PRESTASI_NAMA).sort(function(x,y){return PRESTASI_NAMA[x].localeCompare(PRESTASI_NAMA[y]);})
    .map(function(a){return '<option value="'+a+'">'+esc(PRESTASI_NAMA[a])+'</option>';}).join('');
}
function pilihanBulanPrestasi(){
  var o='';for(var i=0;i>=-3;i--){var k=bulanSemasaKod(i);o+='<option value="'+k+'">'+namaBulanKod(k)+'</option>';}return o;
}
function sediaModalPrestasi(){
  document.getElementById('m-prestasi-atlet').innerHTML=pilihanAtletPrestasi();
  document.getElementById('m-prestasi-atlet').value=document.getElementById('prestasi-athlete').value;
  document.getElementById('m-prestasi-bulan').innerHTML=pilihanBulanPrestasi();
  document.getElementById('m-prestasi-bacaan').value='';
}
var PRESTASI_EDIT_ID=null;
function bukaKemaskiniPrestasi(acara){
  var athlete=document.getElementById('prestasi-athlete').value;
  var d=dataPrestasi(athlete,acara);
  var guna=d.idIni?'ini':(d.idLepas?'lepas':null);
  if(!guna){
    // Tiada rekod lagi: buka borang tambah dengan acara ini dipilih.
    openModal('modal-tambah-prestasi');
    document.getElementById('m-prestasi-acara').value=acara;
    return;
  }
  PRESTASI_EDIT_ID=guna==='ini'?d.idIni:d.idLepas;
  document.getElementById('m-prestasi-edit-atlet').innerHTML=pilihanAtletPrestasi();
  document.getElementById('m-prestasi-edit-atlet').value=athlete;
  document.getElementById('m-prestasi-edit-acara').value=acara;
  document.getElementById('m-prestasi-edit-bulan').innerHTML=pilihanBulanPrestasi();
  document.getElementById('m-prestasi-edit-bulan').value=PRESTASI_BULAN[guna].kod;
  document.getElementById('m-prestasi-edit-bacaan').value=d[guna];
  openModal('modal-kemaskini-prestasi');
}
function padamPrestasi(acara){
  var d=dataPrestasi(document.getElementById('prestasi-athlete').value,acara);
  var id=d.idIni||d.idLepas;
  if(!id){toast('Tiada rekod prestasi untuk dipadam.');return;}
  pilihPadam('prestasi',id);
}
async function simpanPrestasi(aksi){
  var p=aksi==='tambah'?'m-prestasi-':'m-prestasi-edit-';
  var data={
    aksi:aksi,
    id:aksi==='kemaskini'?PRESTASI_EDIT_ID:undefined,
    atlet_id:+document.getElementById(p+'atlet').value,
    acara:document.getElementById(p+'acara').value,
    bulan:document.getElementById(p+'bulan').value,
    bacaan:document.getElementById(p+'bacaan').value
  };
  if(!data.atlet_id||!data.acara||!data.bulan||!data.bacaan){toast('Gagal kemaskini maklumat. Sila lengkapkan semua maklumat prestasi.');return;}
  try{
    var res=await postJson('api/prestasi.php',data);
    closeModal(aksi==='tambah'?'modal-tambah-prestasi':'modal-kemaskini-prestasi');
    document.getElementById('prestasi-athlete').value=data.atlet_id;
    toast(res.message);
    loadPrestasi();
  }catch(error){ralat(error);}
}

/* ── Pakej sukan (admin) ── */
var PAKEJ_SENARAI=null;
var PAKEJ_EDIT_ID=null;
async function muatPakejSenarai(){
  PAKEJ_SENARAI=(await api('api/pakej.php')).data;
  return PAKEJ_SENARAI;
}
async function loadPakej(){
  var tbody=document.getElementById('pakej-tbody');
  try{
    var pakej=await muatPakejSenarai();
    tbody.innerHTML=pakej.length?pakej.map(function(p){
      var poster=p.poster?'background-image:url(&#39;'+esc(encodeURI(p.poster))+'&#39;);background-size:cover;background-position:center;':'background:var(--bg);';
      return '<tr>'+
        '<td><div style="width:48px;height:38px;border-radius:6px;'+poster+'"></div></td>'+
        '<td style="font-weight:500;">'+esc(p.nama_pakej)+'</td>'+
        '<td style="color:var(--tx2);">'+esc(p.sukan)+'</td>'+
        '<td>'+esc(p.hari)+'</td>'+
        '<td>'+esc(p.sesi)+'</td>'+
        '<td style="font-weight:500;">'+rm0(p.harga)+'/bln</td>'+
        '<td><button class="ic-btn" style="color:var(--pri-d)" onclick="pilihPakej('+p.id+')">✎</button><button class="ic-btn" style="color:var(--rd)" onclick="pilihPadam(\'pakej\','+p.id+')">🗑</button></td></tr>';
    }).join(''):'<tr><td colspan="7" style="text-align:center;color:var(--tx3);padding:24px;">Tiada pakej.</td></tr>';
  }catch(error){
    tbody.innerHTML='<tr><td colspan="7" style="text-align:center;padding:24px;">Data gagal dimuatkan. Sila cuba lagi.</td></tr>';
    ralat(error);
  }
}
function pilihPakej(id){
  var p=(PAKEJ_SENARAI||[]).find(function(x){return x.id===id;});
  if(!p){toast('Pakej tidak dijumpai.');return;}
  PAKEJ_EDIT_ID=id;
  document.getElementById('m-pakej-edit-nama').value=p.nama_pakej||'';
  document.getElementById('m-pakej-edit-sukan').value=p.sukan||'';
  document.getElementById('m-pakej-edit-hari').value=p.hari||'';
  document.getElementById('m-pakej-edit-yuran').value=p.harga;
  var sesiSel=document.getElementById('m-pakej-edit-sesi');
  if(!Array.from(sesiSel.options).some(function(o){return o.value===p.sesi;})&&p.sesi){sesiSel.add(new Option(p.sesi,p.sesi));}
  sesiSel.value=p.sesi||'Pagi';
  document.getElementById('m-pakej-edit-poster').value='';
  openModal('modal-kemaskini-pakej');
}
function pilihPoster(input){if(input.files[0])toast('Poster dipilih: '+input.files[0].name);}
async function simpanPakej(aksi){
  var p=aksi==='tambah'?'m-pakej-':'m-pakej-edit-';
  var fd=new FormData();
  fd.append('aksi',aksi);
  if(aksi==='kemaskini')fd.append('id',PAKEJ_EDIT_ID);
  fd.append('nama_pakej',document.getElementById(p+'nama').value.trim());
  fd.append('sukan',document.getElementById(p+'sukan').value.trim());
  fd.append('hari',document.getElementById(p+'hari').value.trim());
  fd.append('harga',document.getElementById(p+'yuran').value);
  fd.append('sesi',document.getElementById(p+'sesi').value);
  var poster=document.getElementById(p+'poster').files[0];
  if(poster)fd.append('poster',poster);
  if(!fd.get('nama_pakej')||!fd.get('sukan')||!fd.get('hari')||!fd.get('harga')){toast('Gagal kemaskini maklumat. Sila lengkapkan semua maklumat pakej.');return;}
  try{
    var res=await api('api/pakej.php',{method:'POST',body:fd});
    closeModal(aksi==='tambah'?'modal-tambah-pakej':'modal-kemaskini-pakej');
    toast(res.message);
    loadPakej();
  }catch(error){ralat(error);}
}

/* ── Jurulatih (admin) ── */
var JURULATIH_SENARAI=[];
var JURULATIH_EDIT_ID=null;
var MEDAN_JURULATIH={nama:'nama',kp:'no_kp',tarikhlahir:'tarikh_lahir',kepakaran:'kepakaran',tel:'telefon',emel:'email',namawaris:'nama_waris',telwaris:'telefon_waris',emelwaris:'emel_waris'};
async function loadJurulatih(){
  var tbody=document.getElementById('jurulatih-tbody');
  try{
    JURULATIH_SENARAI=(await api('api/jurulatih.php')).data;
    tbody.innerHTML=JURULATIH_SENARAI.length?JURULATIH_SENARAI.map(function(j){
      return '<tr>'+
        '<td style="font-weight:500;">'+esc(j.nama)+'</td><td style="color:var(--tx2);">'+esc(j.no_kp||'-')+'</td>'+
        '<td>'+(j.kepakaran?'<span class="badge badge-primary">'+esc(j.kepakaran)+'</span>':'-')+'</td><td>'+esc(j.telefon||'-')+'</td><td style="color:var(--tx2);">'+esc(j.email||'-')+'</td>'+
        '<td><button class="ic-btn" style="color:var(--pri-d)" onclick="pilihJurulatih('+j.id+')">✎</button><button class="ic-btn" style="color:var(--rd)" onclick="pilihPadam(\'jurulatih\','+j.id+')">🗑</button></td></tr>';
    }).join(''):'<tr><td colspan="6" style="text-align:center;color:var(--tx3);padding:24px;">Tiada rekod jurulatih. Klik "+ Tambah Jurulatih" untuk menambah.</td></tr>';
  }catch(error){
    tbody.innerHTML='<tr><td colspan="6" style="text-align:center;padding:24px;">Data gagal dimuatkan. Sila cuba lagi.</td></tr>';
    ralat(error);
  }
}
function pilihJurulatih(id){
  var j=JURULATIH_SENARAI.find(function(x){return +x.id===id;});
  if(!j){toast('Rekod jurulatih tidak dijumpai.');return;}
  JURULATIH_EDIT_ID=id;
  Object.keys(MEDAN_JURULATIH).forEach(function(f){document.getElementById('m-jurulatih-edit-'+f).value=j[MEDAN_JURULATIH[f]]||'';});
  openModal('modal-kemaskini-jurulatih');
}
async function simpanJurulatih(aksi){
  var p=aksi==='tambah'?'m-jurulatih-':'m-jurulatih-edit-';
  var data={aksi:aksi};
  if(aksi==='kemaskini')data.id=JURULATIH_EDIT_ID;
  Object.keys(MEDAN_JURULATIH).forEach(function(f){data[MEDAN_JURULATIH[f]]=document.getElementById(p+f).value.trim();});
  if(['nama','no_kp','tarikh_lahir','kepakaran','telefon','email','nama_waris','telefon_waris'].some(function(k){return !data[k];})){
    toast('Gagal kemaskini maklumat. Sila lengkapkan semua maklumat wajib jurulatih.');return;
  }
  try{
    var res=await postJson('api/jurulatih.php',data);
    closeModal(aksi==='tambah'?'modal-tambah-jurulatih':'modal-kemaskini-jurulatih');
    toast(res.message);
    loadJurulatih();
  }catch(error){ralat(error);}
}

/* ── Dashboard ── */
function masaLalu(t){
  if(!t)return '';
  var saat=(Date.now()-new Date(String(t).replace(' ','T')).getTime())/1000;
  if(isNaN(saat))return '';
  if(saat<60)return 'baru sahaja';
  if(saat<3600)return Math.floor(saat/60)+' minit lepas';
  if(saat<86400)return Math.floor(saat/3600)+' jam lepas';
  return Math.floor(saat/86400)+' hari lepas';
}
async function muatkanDashboardAdmin(){
  try{
    var d=(await api('api/dashboard-admin.php')).data;
    var bln=d.bulan_semasa.split(' ');
    var idx=BULAN_MS.indexOf(bln[0]);
    document.getElementById('dash-admin-atlet').textContent=d.jumlah_atlet;
    document.getElementById('dash-admin-kutipan-label').textContent='Kutipan Yuran ('+BULAN_PENDEK[idx]+')';
    document.getElementById('dash-admin-kutipan').textContent=rm0(d.kutipan_bulan_ini);
    document.getElementById('dash-admin-kutipan-note').textContent='Daripada '+d.bil_atlet_bayar+' atlet';
    document.getElementById('dash-admin-hadir').textContent=d.kehadiran_purata==null?'–':d.kehadiran_purata+'%';
    document.getElementById('dash-admin-hadir-note').textContent=d.bulan_semasa;
    document.getElementById('dash-admin-tertunggak').textContent=d.tertunggak;
    document.getElementById('dash-admin-carta-title').textContent='Kutipan Yuran '+bln[1]+' (RM)';
    var maks=d.carta.reduce(function(m,c){return Math.max(m,c.jumlah);},0);
    document.getElementById('dash-admin-carta').innerHTML=d.carta.map(function(c,i){
      var h=maks>0?Math.round(c.jumlah/maks*79):0;
      return '<div class="bar-col"><div class="bar-val">'+rm0(c.jumlah)+'</div><div class="bar" style="height:'+h+'px;"></div><div class="bar-lbl">'+BULAN_PENDEK[i]+'</div></div>';
    }).join('');
    var gayaAv='width:34px;height:34px;border-radius:50%;background:var(--pri-l);color:var(--pri-d);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;';
    document.getElementById('dash-admin-terkini').innerHTML='<div class="card-title">Pendaftaran Terkini</div>'+(d.terkini.length?d.terkini.map(function(a){
      var masa=masaLalu(a.tarikh_daftar);
      return '<div style="display:flex;align-items:center;gap:12px;padding:11px 0;border-bottom:1px solid var(--border);">'+
        '<div class="av" style="'+gayaAv+'">'+esc(inisial(a.nama))+'</div>'+
        '<div><div style="font-weight:500;">'+esc(a.nama)+'</div><div style="font-size:12px;color:var(--tx2);">'+esc(a.pakej||'-')+(masa?' · '+masa:'')+'</div></div></div>';
    }).join(''):'<div class="empty">Tiada pendaftaran.</div>');
  }catch(error){ralat(error,'Data dashboard gagal dimuatkan.');}
}
var HARI_MINGGU=['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'];
function latihanSeterusnya(hari){
  if(!hari)return '-';
  var hariLatihan=HARI_MINGGU.map(function(h,i){return hari.indexOf(h)>-1?i:-1;}).filter(function(i){return i>-1;});
  if(!hariLatihan.length)return '-';
  var d=new Date();
  for(var n=0;n<7;n++){
    if(hariLatihan.indexOf(d.getDay())>-1){
      var t=d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0');
      return HARI_MINGGU[d.getDay()]+', '+formatTarikh(t);
    }
    d.setDate(d.getDate()+1);
  }
  return '-';
}
async function muatkanDashboardAtlet(){
  try{
    var d=(await api('api/dashboard-atlet.php')).data;
    var sesiPendek=String(d.atlet.sesi||'').split(' (')[0];
    document.getElementById('dash-pakej').textContent=d.atlet.pakej||'-';
    document.getElementById('dash-pakej-info').textContent=(sesiPendek||'-')+(d.harga!=null?' · '+rm0(d.harga)+'/bulan':'');
    var pct=d.jumlah_sesi?Math.round(d.hadir/d.jumlah_sesi*100):null;
    document.getElementById('dash-hadir-label').textContent='Kehadiran '+d.bulan_semasa;
    var pctEl=document.getElementById('dash-hadir-pct');
    pctEl.textContent=pct==null?'–':pct+'%';
    pctEl.style.color=pct==null?'var(--tx3)':pctColor(pct);
    document.getElementById('dash-hadir-note').textContent=d.hadir+' daripada '+d.jumlah_sesi+' sesi';
    document.getElementById('dash-hadir-bulan').textContent=d.bulan_semasa;
    document.getElementById('dash-hadir-sesi').textContent=d.hadir+' / '+d.jumlah_sesi+' sesi';
    var prog=document.getElementById('dash-hadir-prog');
    prog.style.width=(pct||0)+'%';
    prog.className='prog'+(pct==null||pct>=80?'':pct>=60?' warn':' danger');
    document.getElementById('dash-latihan-seterusnya').textContent=latihanSeterusnya(d.hari);
    var inv=d.invois_terkini;
    var st=inv?(STATUS_BAYAR[inv.status]||STATUS_BAYAR.belum):null;
    document.getElementById('dash-yuran-badge').innerHTML=st?'<span class="badge '+st.badge+'">'+st.teks+'</span>':'<span class="badge badge-default">Tiada Invois</span>';
    document.getElementById('dash-yuran-bulan').textContent=inv?inv.bulan:'-';
    var t=d.invois_tertunggak;
    ATLET_YURAN.sudahBayar=!t;
    if(t){
      document.getElementById('dash-notif-teks').textContent=t.status==='ditolak'
        ?'Bukti pembayaran invois '+t.bulan+' ditolak ('+rm2(t.jumlah)+'). Sila muat naik semula.'
        :'Invois '+t.bulan+' belum dibayar ('+rm2(t.jumlah)+').';
    }
    document.getElementById('dashInvoisNotif').style.display=t?'':'none';
    document.getElementById('dash-prestasi-tbody').innerHTML=d.prestasi.length?d.prestasi.map(function(p){
      var dp=PRESTASI_DP[p.acara]!=null?PRESTASI_DP[p.acara]:1;
      var unit=p.acara.indexOf('(saat)')>-1?'s':(p.acara.indexOf('(m)')>-1?' m':'');
      var pc=prestasiPctVal(p.acara,p.sebelum,p.terkini);
      var ubah=pc==null?'<td style="color:var(--tx3);">Rekod pertama</td>'
        :'<td style="color:'+(pc>=0?'var(--gn)':'var(--rd)')+';font-weight:600;">'+(pc>=0?'↑ +':'↓ ')+pc.toFixed(1)+'%</td>';
      return '<tr><td>'+esc(p.acara.split(' (')[0])+'</td><td>'+p.terkini.toFixed(dp)+unit+'</td>'+ubah+'</tr>';
    }).join(''):'<tr><td colspan="3" style="text-align:center;color:var(--tx3);">Tiada rekod prestasi.</td></tr>';
  }catch(error){ralat(error,'Data dashboard gagal dimuatkan.');}
}

// Kategori atlet: belum bayar yuran pendaftaran / baharu (< 1 bulan) / berdaftar (>= 1 bulan).
var KATEGORI_ATLET={
  belum:{teks:'Belum Berdaftar',badge:'badge-danger'},
  baharu:{teks:'Atlet Baharu',badge:'badge-info'},
  berdaftar:{teks:'Atlet Berdaftar',badge:'badge-success'}
};
function badgeStatusAtlet(kategori){
  var kat=KATEGORI_ATLET[kategori]||KATEGORI_ATLET.belum;
  return '<span class="badge '+kat.badge+'">'+kat.teks+'</span>';
}
async function loadAtlet() {
  const tbody = document.getElementById('atlet-tbody');

  try {
    const response = await fetch('api/senarai-atlet.php');
    const result = await response.json();

    if (!response.ok || !result.success) {
      throw new Error('Data atlet gagal dimuatkan.');
    }

    if (result.data.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="6" style="text-align:center;padding:24px;">
            Tiada rekod atlet.
          </td>
        </tr>`;
      return;
    }

    tbody.innerHTML = result.data.map(function(atlet) {
      const selamat = esc;

      return `
        <tr>
          <td><div style="font-weight:500;">${selamat(atlet.nama)}</div></td>
          <td style="color:var(--tx2);">${selamat(atlet.no_kp)}</td>
          <td>${selamat(atlet.pakej)}</td>
          <td style="color:var(--tx2);">${selamat(atlet.email)}</td>
          <td>${badgeStatusAtlet(atlet.kategori)}</td>
          <td>
<button class="ic-btn" style="color:var(--pri-d)"
  onclick="pilihAtletUntukDikemaskini(${Number(atlet.id)})" title="Kemaskini">✎</button>
<button class="ic-btn" style="color:var(--rd)"
  onclick="pilihAtletUntukDipadam(${Number(atlet.id)})" title="Padam">🗑</button>
          </td>
        </tr>`;
    }).join('');

    filterAtlet();

  } catch (error) {
    console.error(error);
    tbody.innerHTML = `
      <tr>
        <td colspan="6" style="text-align:center;padding:24px;">
          Data gagal dimuatkan. Sila cuba lagi.
        </td>
      </tr>`;
  }
}

let atletUntukDipadam = null;
function pilihAtletUntukDipadam(id) {
  atletUntukDipadam = id;
  PADAM_SASARAN = {jenis: 'atlet', id: id};
  openModal('modal-padam');
}
let atletUntukDikemaskini = null;

// Pilihan sesi dalam modal kemaskini atlet mengikut pakej yang dipilih.
function isiSesiModalAtlet(sesiSemasa){
  const sesiSelect = document.getElementById('m-atlet-sesi');
  const pilihan = sesiUntukPakej(document.getElementById('m-atlet-pakej').value);
  sesiSelect.innerHTML = pilihan.map(s => '<option>' + esc(s) + '</option>').join('');
  if (sesiSemasa && pilihan.indexOf(sesiSemasa) > -1) sesiSelect.value = sesiSemasa;
}
document.getElementById('m-atlet-pakej').addEventListener('change', function(){ isiSesiModalAtlet(); });

async function pilihAtletUntukDikemaskini(id) {
  atletUntukDikemaskini = id;

  try {
    const response = await fetch('api/senarai-atlet.php');
    const result = await response.json();

    if (!response.ok || !result.success) {
      toast('Maklumat atlet gagal dimuatkan.');
      return;
    }

    const atlet = result.data.find(item => Number(item.id) === Number(id));

    if (!atlet) {
      toast('Rekod atlet tidak dijumpai.');
      return;
    }

    document.getElementById('m-atlet-nama').value = atlet.nama || '';
    document.getElementById('m-atlet-kp').value = atlet.no_kp || '';
    document.getElementById('m-atlet-tarikhlahir').value = atlet.tarikh_lahir || '';
    document.getElementById('m-atlet-emel').value = atlet.email || '';

    // Senarai pakej diambil daripada pangkalan data (termasuk pakej baharu).
    const pakejSelect = document.getElementById('m-atlet-pakej');
    try {
      const senarai = await muatPakejSenarai();
      if (senarai.length) {
        pakejSelect.innerHTML = senarai.map(p => '<option>' + esc(p.nama_pakej) + '</option>').join('');
      }
    } catch (e) { console.error(e); }
    const pakejPilihan = Array.from(pakejSelect.options).find(
      option => option.value === atlet.pakej || option.textContent === atlet.pakej
    );
    if (pakejPilihan) pakejSelect.value = pakejPilihan.value;

    isiSesiModalAtlet(atlet.sesi);

    document.getElementById('m-atlet-telwaris').value = atlet.no_telefon_waris || '';

    openModal('modal-kemaskini-atlet');

  } catch (error) {
    console.error(error);
    toast('Tidak dapat memuatkan maklumat atlet.');
  }
}
async function padamAtlet() {
  if (!atletUntukDipadam) {
    toast('Sila pilih rekod atlet yang hendak dipadam.');
    return;
  }

  try {
    const response = await fetch('api/padam-atlet.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        id: atletUntukDipadam
      })
    });

    const result = await response.json();

    if (!response.ok || !result.success) {
      toast(result.message || 'Rekod atlet gagal dipadam.');
      return;
    }

    closeModal('modal-padam');
    atletUntukDipadam = null;
    PADAM_SASARAN = null;

    toast('Rekod atlet berjaya dipadam!');

    await loadAtlet();

  } catch (error) {
    console.error(error);
    toast('Tidak dapat menghubungi server. Sila cuba lagi.');
  }
}

// Fungsi pemuat data bagi setiap halaman (dipanggil oleh go()).
// Kad pakej halaman utama mengikut jadual pakej_sukan (pakej baharu admin turut dipaparkan).
async function muatPakejLanding(){
  try{
    var senarai=(await api('api/pakej.php')).data;
    if(!senarai.length)return;
    document.getElementById('landing-pakej').innerHTML=senarai.map(function(p){
      var poster=p.poster?"background-image:url('"+esc(encodeURI(p.poster))+"');background-size:contain;background-repeat:no-repeat;background-position:center;":'background:var(--bg);';
      var sesi=(PAKEJ_SESI[p.nama_pakej.replace(/^Pakej /,'')]||[]).map(function(s){return s.replace(/^Sesi /,'');}).join(' atau ')||p.sesi;
      var butiran=[p.hari,sesi,p.sukan].filter(Boolean).map(esc).join(' · ');
      return '<div class="pkg-card" onclick="go(&#39;p-login&#39;)"><div class="pkg-banner" style="'+poster+'"></div><div class="pkg-info">'+
        '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:3px;"><span class="pkg-name">'+esc(p.nama_pakej)+'</span></div>'+
        '<div class="pkg-detail">'+butiran+'</div><div class="pkg-price">RM'+Math.round(p.harga)+'<small>/bulan</small></div></div></div>';
    }).join('');
  }catch(error){console.error(error);}
}
var PEMUAT_HALAMAN={
  'p-landing':muatPakejLanding,
  'p-daftar2':muatPakejDaftar,
  'p-invois':paparInvoisPendaftaran,
  'p-dash-atlet':muatkanDashboardAtlet,
  'p-profil-atlet':muatkanHalamanProfilAtlet,
  'p-bayar-atlet':muatkanPembayaranAtlet,
  'p-dash-admin':muatkanDashboardAdmin,
  'p-profil-admin':muatkanProfilAdmin,
  'p-atlet-admin':loadAtlet,
  'p-pakej-admin':loadPakej,
  'p-bayar-admin':loadBayarAdmin,
  'p-prestasi-admin':loadPrestasi,
  'p-hadir-admin':loadHadirHalaman,
  'p-jurulatih-admin':loadJurulatih
};

// Semasa halaman dimuat (atau dimuat semula), pulihkan sesi log masuk jika masih sah.
(async function mulaAplikasi(){
  muatPakejLanding();
  var mesej=bacaStorage('at_toast');
  if(mesej){simpanStorage('at_toast',null);toast(mesej);}
  try{
    var j=await api('api/sesi.php');
    if(j.data){
      SESI=j.data;
      var simpan=bacaStorage('at_halaman');
      go(simpan&&perananHalaman(simpan)===SESI.peranan?simpan:dashboardPeranan());
    }
  }catch(error){console.error(error);}
})();
</script>

</body></html>