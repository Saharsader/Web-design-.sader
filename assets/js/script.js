const btnOpenDropdown = Array.from(
  document.querySelectorAll('.open-drop_down')
);

btnOpenDropdown.forEach((btn) => {
  const target = btn.getAttribute('href');
  const dropdown = document.querySelector(target);
  console.log(btn);
  btn.addEventListener('click', (event) => {
    event.preventDefault();
    dropdown.classList.toggle('show-dropdown');
  });
});
