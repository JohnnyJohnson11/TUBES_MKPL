document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll('.tabs a'); // Select all tab links
    
    tabs.forEach(tab => {
      tab.addEventListener('click', (event) => {
        // Remove 'active' class from all tabs
        tabs.forEach(t => t.classList.remove('active'));
        
        // Add 'active' class to the clicked tab
        event.target.classList.add('active');
      });
    });
  });

  function showPopup() {
    document.getElementById('popup').style.display = 'flex';
  }
  function closePopup() {
    document.getElementById('popup').style.display = 'none';
  }

  document.querySelector('.no-btn').onclick = () => {
    closePopup();
  };
  document.querySelector('.accept-btn').onclick = ()=>{
    showPopup();
  };
  document.getElementById('popup').style.display = 'none';