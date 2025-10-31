<body>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid"> <a class="navbar-brand" href="#">Fixed navbar</a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav me-auto mb-2 mb-md-0">
          <li class="nav-item"> <a class="nav-link active" aria-current="page" href="#">Home</a> </li>
          <li class="nav-item"> <a class="nav-link" href="#">Link</a> </li>
          <li class="nav-item"> <a class="nav-link disabled" aria-disabled="true">Disabled</a> </li>
        </ul>
        <form class="d-flex" role="search"> <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"> <button class="btn btn-outline-success" type="submit">Search</button> </form>
      </div>
    </div>
  </nav>
  <main class="container">
    <div class="bg-body-tertiary p-5 rounded">
      <div class="container">
        <ul class="nav nav-tabs" id="iconTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="car-tab" data-bs-toggle="tab" data-bs-target="#car" type="button" role="tab">
              <i class="bi bi-car-front"></i>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab">
              <i class="bi bi-journal-text"></i>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="photo-tab" data-bs-toggle="tab" data-bs-target="#photo" type="button" role="tab">
              <i class="bi bi-image"></i>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="checklist-tab" data-bs-toggle="tab" data-bs-target="#checklist" type="button" role="tab">
              <i class="bi bi-card-checklist"></i>
            </button>
          </li>
        </ul>

        <div class="tab-content border border-top-0 p-4 bg-white" id="iconTabContent">
          <div class="tab-pane fade show active" id="car" role="tabpanel" aria-labelledby="car-tab">
            <?php include_once('tab1.php') ?>
          </div>
          <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
            <?php include_once('tab2.php') ?>
          </div>
          <div class="tab-pane fade" id="photo" role="tabpanel" aria-labelledby="photo-tab">
            <?php include_once('tab3.php') ?>
          </div>
          <div class="tab-pane fade" id="checklist" role="tabpanel" aria-labelledby="checklist-tab">
            <?php include_once('tab4.php') ?>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>