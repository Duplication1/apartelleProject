<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StocksLevel</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!--Sa Boostrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--Sa Boostrap-->
</head>
<body>
   
    
    <!--Access control-->
    <div class="container mt-5" >   
       
        <div class="d-flex align-items-center me-100 float-end mb-10">
            <p class="mb-0">Show</p>
            <div class="dropdown mx-2  mb-10">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    100
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#" onclick="updateButton(100)">100</a></li>
                    <li><a class="dropdown-item" href="#" onclick="updateButton(75)">75</a></li>
                    <li><a class="dropdown-item" href="#" onclick="updateButton(50)">50</a></li>
                    <li><a class="dropdown-item" href="#" onclick="updateButton(25)">25</a></li>
                    <li><a class="dropdown-item" href="#" onclick="updateButton(10)">10</a></li>
                </ul>
            </div>

            <p class="mb-0">records</p>
        </div>
    </div>
    <!-- Dropdown -->

    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
      <th scope="col">Time Log</th>
    </tr>
  </thead>
  <tbody class="">
    <tr>
      <th scope="row">1</th>
      <td></td>
      <td></td>
      
    </tr>
    <tr>
      <th scope="row">2</th>
      <td></td>
      <td></td>      
    </tr>
  </tbody>
</table>

  

   
    <script src="script.js"></script>
    
    
    <!--Sa Boostrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <!--nag add ako auto update kapa pinindot yun record-->
    <script>
        function updateButton(value) {
            document.getElementById('dropdownMenuButton').innerText = value;
        }
    </script>
</body>

</html>