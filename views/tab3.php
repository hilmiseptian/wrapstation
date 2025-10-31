<style>
  .car-container {
    position: relative;
    width: 600px;
    height: 400px;
    margin: auto;
    background: url('https://upload.wikimedia.org/wikipedia/commons/5/56/Car_icon_top.svg') no-repeat center;
    background-size: contain;
  }

  .upload-zone {
    position: absolute;
    border: 2px dashed red;
    border-radius: 6px;
    width: 100px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
  }

  .upload-zone img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
  }

  /* Placement for mock zones */
  .front {
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
  }

  .rear {
    bottom: 10%;
    left: 50%;
    transform: translateX(-50%);
  }

  .left {
    top: 45%;
    left: 10%;
  }

  .right {
    top: 45%;
    right: 10%;
  }
</style>

<div class="container">
  <h3 class="mb-4">Car Overview</h3>
  <p class="text-muted">Click each red box to upload photos of car parts.</p>

  <div class="car-container">
    <div class="upload-zone front" id="zone-front" data-part="front">Front</div>
    <div class="upload-zone rear" id="zone-rear" data-part="rear">Rear</div>
    <div class="upload-zone left" id="zone-left" data-part="left">Left</div>
    <div class="upload-zone right" id="zone-right" data-part="right">Right</div>
  </div>
</div>

<!-- Hidden file input -->
<input type="file" id="fileInput" accept="image/*" hidden>