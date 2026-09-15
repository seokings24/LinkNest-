<?php require __DIR__.'/lib.php'; $links=get_links(); ?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>LinkNest Dashboard</title><link rel="stylesheet" href="style.css"></head>
<body class="dash"><aside><div class="brand"><span class="logo">↗</span><div><b>LinkNest</b><small>CONTROL CENTER</small></div></div><div class="label">WORKSPACE</div><a class="active">Overview</a><a href="#create">Create Link</a><a href="#links">My Links</a><div class="online">● Browser Workspace</div></aside>
<section class="main"><div class="head"><div><span class="tag">MY WORKSPACE</span><h1>Link Dashboard</h1><p>Create, copy and delete your links.</p></div></div><div id="message"></div>
<div class="columns"><form id="create" class="panel"><h2>Create New Link</h2>
<label>URL SLUG<input name="slug" required pattern="[A-Za-z0-9_-]+" placeholder="example-link"></label>
<label>TITLE<input name="title" required placeholder="My photo"></label>
<label>PHOTO URL<input name="image" type="url" required placeholder="https://example.com/photo.jpg"></label>
<div id="preview" class="formPreview hidden"><img id="previewImg" alt="Preview"></div>
<label>DESTINATION URL<input name="destination" type="url" required placeholder="https://example.com"></label>
<button class="btn wide">Create Link →</button></form>
<div id="links" class="panel"><div class="listHead"><h2>My Links</h2><span id="count">0</span></div><div id="list"><div class="empty">Loading...</div></div></div></div></section>
<script>
const form=document.querySelector('form'),img=form.image,pre=document.querySelector('#preview'),pi=document.querySelector('#previewImg');
img.oninput=()=>{if(/^https?:\/\//i.test(img.value)){pre.classList.remove('hidden');pi.src=img.value}else pre.classList.add('hidden')};
const esc=s=>String(s).replace(/[&<>"']/g,m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m]));
function message(t){document.querySelector('#message').textContent=t;setTimeout(()=>document.querySelector('#message').textContent='',3000)}
async function load(){let r=await fetch('api.php?action=list',{cache:'no-store'}),d=await r.json();if(!r.ok)return message(d.error);render(d.links)}
function render(a){count.textContent=a.length;list.innerHTML=a.length?a.map(x=>`<div class="item"><img src="${esc(x.image)}" alt=""><div class="itemInfo"><b>${esc(x.title)}</b><small>${esc(location.origin+'/go/'+x.slug)}</small></div><button data-c="${esc(x.slug)}">Copy</button><a href="go/${encodeURIComponent(x.slug)}" target="_blank">Open</a><button class="delete" data-d="${esc(x.slug)}">×</button></div>`).join(''):'<div class="empty">No links created in this browser.</div>'}
form.onsubmit=async e=>{e.preventDefault();let r=await fetch('api.php?action=create',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(Object.fromEntries(new FormData(form)))}),d=await r.json();if(!r.ok)return message(d.error);form.reset();pre.classList.add('hidden');load();message('Link created successfully.')}
document.onclick=async e=>{if(e.target.dataset.c){await navigator.clipboard.writeText(location.origin+'/go/'+e.target.dataset.c);e.target.textContent='Copied';setTimeout(()=>e.target.textContent='Copy',1200)}if(e.target.dataset.d&&confirm('Delete this link?')){await fetch('api.php?action=delete',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({slug:e.target.dataset.d})});load()}}
load();
</script></body></html>