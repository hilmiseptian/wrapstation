<style>
  body {
    background-color: #f8f9fa;
  }

  .section-title {
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
  }

  .rating-group label {
    margin-right: 10px;
  }

  .rating-group input[type="radio"] {
    display: none;
  }

  .rating-group label span {
    display: inline-block;
    padding: 8px 16px;
    background-color: #e9ecef;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
  }

  .rating-group input[type="radio"]:checked+span {
    background-color: #0d6efd;
    color: #fff;
  }
</style>
<div class="container">
  <h3 class="mb-4"><i class="bi bi-card-checklist"></i> Vehicle Inspection</h3>
  <p class="text-muted">G = Good | F = Fair | P = Poor</p>

  <form id="inspectionForm">

    <!-- Paint -->
    <div class="mb-3">
      <label class="form-label fw-bold">Paint</label>
      <div class="rating-group mb-2">
        <label><input type="radio" name="paint" value="G"><span>G</span></label>
        <label><input type="radio" name="paint" value="F"><span>F</span></label>
        <label><input type="radio" name="paint" value="P"><span>P</span></label>
      </div>
      <div class="extra-fields d-none">
        <textarea class="form-control mb-2" rows="2" placeholder="Notes..."></textarea>
        <input type="file" class="form-control">
      </div>
    </div>

    <h5 class="section-title">Glass</h5>
    <!-- Windshield -->
    <div class="mb-3">
      <label class="form-label fw-bold">Windshield</label>
      <div class="rating-group mb-2">
        <label><input type="radio" name="windshield" value="G"><span>G</span></label>
        <label><input type="radio" name="windshield" value="F"><span>F</span></label>
        <label><input type="radio" name="windshield" value="P"><span>P</span></label>
      </div>
      <div class="extra-fields d-none">
        <textarea class="form-control mb-2" rows="2" placeholder="Notes..."></textarea>
        <input type="file" class="form-control">
      </div>
    </div>

    <!-- Windows -->
    <div class="mb-3">
      <label class="form-label fw-bold">Windows</label>
      <div class="rating-group mb-2">
        <label><input type="radio" name="windows" value="G"><span>G</span></label>
        <label><input type="radio" name="windows" value="F"><span>F</span></label>
        <label><input type="radio" name="windows" value="P"><span>P</span></label>
      </div>
      <div class="extra-fields d-none">
        <textarea class="form-control mb-2" rows="2" placeholder="Notes..."></textarea>
        <input type="file" class="form-control">
      </div>
    </div>

    <!-- Mirrors -->
    <div class="mb-3">
      <label class="form-label fw-bold">Mirrors</label>
      <div class="rating-group mb-2">
        <label><input type="radio" name="mirrors" value="G"><span>G</span></label>
        <label><input type="radio" name="mirrors" value="F"><span>F</span></label>
        <label><input type="radio" name="mirrors" value="P"><span>P</span></label>
      </div>
      <div class="extra-fields d-none">
        <textarea class="form-control mb-2" rows="2" placeholder="Notes..."></textarea>
        <input type="file" class="form-control">
      </div>
    </div>

    <!-- Rear Window -->
    <div class="mb-3">
      <label class="form-label fw-bold">Rear Window</label>
      <div class="rating-group mb-2">
        <label><input type="radio" name="rear_window" value="G"><span>G</span></label>
        <label><input type="radio" name="rear_window" value="F"><span>F</span></label>
        <label><input type="radio" name="rear_window" value="P"><span>P</span></label>
      </div>
      <div class="extra-fields d-none">
        <textarea class="form-control mb-2" rows="2" placeholder="Notes..."></textarea>
        <input type="file" class="form-control">
      </div>
    </div>

    <h5 class="section-title">Tires and Wheels</h5>
    <!-- Tires -->
    <div class="mb-3">
      <label class="form-label fw-bold">Tires</label>
      <div class="rating-group mb-2">
        <label><input type="radio" name="tires" value="G"><span>G</span></label>
        <label><input type="radio" name="tires" value="F"><span>F</span></label>
        <label><input type="radio" name="tires" value="P"><span>P</span></label>
      </div>
      <div class="extra-fields d-none">
        <textarea class="form-control mb-2" rows="2" placeholder="Notes..."></textarea>
        <input type="file" class="form-control">
      </div>
    </div>

    <!-- Wheels -->
    <div class="mb-3">
      <label class="form-label fw-bold">Wheels</label>
      <div class="rating-group mb-2">
        <label><input type="radio" name="wheels" value="G"><span>G</span></label>
        <label><input type="radio" name="wheels" value="F"><span>F</span></label>
        <label><input type="radio" name="wheels" value="P"><span>P</span></label>
      </div>
      <div class="extra-fields d-none">
        <textarea class="form-control mb-2" rows="2" placeholder="Notes..."></textarea>
        <input type="file" class="form-control">
      </div>
    </div>

  </form>
</div>