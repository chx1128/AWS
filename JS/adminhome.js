/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('salesChart').getContext('2d');
  
    var salesChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Ducky Ducky', 'Likely Ducky', 'Twins Package', 'Family Package', 'Happy Ducky', 'Aunty Ducky'],
        datasets: [{
          label: 'Sales Performance',
          data: [1031, 1514, 2005, 1834, 2563, 2259],
          backgroundColor: 'rgba(255, 216, 1)',
          borderColor: 'rgba(0, 0, 0)',
          borderWidth: 1
        }]
      },
    });
  });
  

