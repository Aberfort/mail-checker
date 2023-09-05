document.addEventListener("DOMContentLoaded", function () {
  const testBtn = document.querySelector('#btn_send');

  if (!testBtn) {
    return;
  }

  testBtn.addEventListener('click', async () => {

    const parent = testBtn.parentElement.parentElement;

    myAjax().then((data) => {
      parent.innerHTML += '<p class="appended">Your test has been sent!</p>';
      const element = document.querySelector('.appended');

      function myMessage() {
        element.remove();
      }
      setTimeout(myMessage, 3000);
    })

  });
});

async function myAjax() {
  let result
  try {
    const data = new FormData();
    data.append('action', 'get_ajax');
    result = await fetch(simple_ajax_url_obj.ajax_url, {
      method: 'POST',
      body: data
    })

    return result
  } catch (error) {
    console.error(error)
  }
}