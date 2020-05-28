const saveBtn = document.querySelector('.save');

saveBtn.addEventListener('click', (e) => {
  e.preventDefault();
  const data = new FormData();

  const result = document.querySelector('input[name=result]').value;
  data.append('result', result);

  fetch('Calculations.php', {
    method: 'post',
    body: data
  })
    .then((res) => res.json())
    .then((data) => {
      console.log(data)
    })
    .catch((error) => console.log(error));
});
