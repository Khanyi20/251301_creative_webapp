function toggleExtra(btn, extraId) {
    const extra = document.getElementById(extraId);
    const label = btn.querySelector('.btn-label');

    extra.classList.toggle('open');
    btn.classList.toggle('open');

    label.textContent = extra.classList.contains('open') ? 'See less' : 'See more';
  }