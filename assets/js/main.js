// Minimal JS placeholder
console.log('Jumia clone ready');

// Image preview helper for file inputs (used in admin add/edit product)
function previewImage(inputId, imgId) {
  const inp = document.getElementById(inputId);
  const img = document.getElementById(imgId);
  if(!inp || !img) return;
  inp.addEventListener('change', function(e) {
    const file = this.files[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) { img.src = ev.target.result; img.style.display='block'; }
    reader.readAsDataURL(file);
  });
}

// Initialize when DOM ready for known inputs (IDs used in admin pages)
document.addEventListener('DOMContentLoaded', function(){ try{ previewImage('image','image_preview'); }catch(e){} });
