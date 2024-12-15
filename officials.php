<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Management</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="resources/css/table.css">
    <link rel="stylesheet" href="resources/css/forms.css">
</head>

<body>
    <?php
    require_once 'C:\xampp\htdocs\BRGY SYSTEM\database\Official.php';
    require_once 'C:\xampp\htdocs\BRGY SYSTEM\database\Resident.php';
    include 'C:\xampp\htdocs\BRGY SYSTEM\assets\php\header.php';
    ?>
    <div class="container-fluid mt-4">
        <h1 class="mb-4">
            <b>OFFICIAL LIST</b>
            <!-- Trigger Modal for Adding Official -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOfficialModal">Add Official</button>
        </h1>
        <div>
            <div class="card">
                <div class="card-body">
                    <div class="table-container">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Official's ID</th>
                                    <th>Position</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Term Start</th>
                                    <th>Term End</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $officials = new Official();
                                $officials = $officials->getOfficials();
                                if (!empty($officials)): ?>
                                    <p class="fas fa-users" id="total">Total Officials: <?= count($officials) ?></p>
                                    <?php foreach ($officials as $officialData): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($officialData['official_id']) ?></td>
                                            <td><?= htmlspecialchars($officialData['position']) ?></td>
                                            <td><?= htmlspecialchars($officialData['last_name']) ?></td>
                                            <td><?= htmlspecialchars($officialData['first_name']) ?></td>
                                            <td><?= htmlspecialchars($officialData['middle_name']) ?></td>
                                            <td><?= htmlspecialchars($officialData['office_start_date']) ?></td>
                                            <td><?= htmlspecialchars($officialData['office_end_date']) ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateOfficialModal<?= htmlspecialchars($officialData['official_id']) ?>">
                                                                <i class="fas fa-edit" title="Update Official"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" id="delete" data-bs-toggle="modal" data-bs-target="#deleteOfficialModal<?= htmlspecialchars($officialData['official_id']) ?>">
                                                                <i class="fas fa-trash-alt" title="Delete Official"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Delete Official Modal -->
                                        <div class="modal fade" id="deleteOfficialModal<?= htmlspecialchars($officialData['official_id']) ?>" tabindex="-1" aria-labelledby="deleteOfficialModalLabel<?= htmlspecialchars($officialData['Official_id']) ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteOfficialModal">Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to remove this official (<?=htmlspecialchars($officialData['official_id']) . ") " . htmlspecialchars($officialData['first_name']) . " " . htmlspecialchars($officialData['last_name']) ; ?>)? This action cannot be undone.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <a type="button" class="btn btn-danger" href="includes/officials/remove_official.php?id=<?= htmlspecialchars($officialData['official_id']) ?>">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Update Official Modal -->
                                        <div class="modal fade" id="updateOfficialModal<?= htmlspecialchars($officialData['official_id']) ?>" tabindex="-1" aria-labelledby="updateOfficialModalLabel<?= htmlspecialchars($officialData['official_id']) ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Official</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="includes/officials/update_official.php?id=<?= htmlspecialchars($officialData['official_id']) ?>" method="POST">
                                                            <div class="row">
                                                                <div class="col-md-6 form-group">
                                                                    <label for="position">Position:</label>
                                                                    <select class="form-control" id="position" name="position" required>
                                                                        <option value="Barangay Captain" <?php echo $officialData['position'] == 'Barangay Captain' ? 'selected' : ''; ?>>Barangay Captain</option>
                                                                        <option value="Barangay Kagawad" <?php echo $officialData['position'] == 'Barangay Kagawad' ? 'selected' : ''; ?>>Barangay Kagawad</option>
                                                                        <option value="Barangay Secretary" <?php echo $officialData['position'] == 'Barangay Secretary' ? 'selected' : ''; ?>>Barangay Secretary</option>
                                                                        <option value="Barangay Treasurer" <?php echo $officialData['position'] == 'Barangay Treasurer' ? 'selected' : ''; ?>>Barangay Treasurer</option>
                                                                        <option value="Barangay Tanod" <?php echo $officialData['position'] == 'Barangay Tanod' ? 'selected' : ''; ?>>Barangay Tanod</option>
                                                                        <option value="Barangay Chairperson" <?php echo $officialData['position'] == 'Barangay Chairperson' ? 'selected' : ''; ?>>Barangay Chairperson</option>
                                                                        <option value="Barangay SK Chairperson" <?php echo $officialData['position'] == 'Barangay SK Chairperson' ? 'selected' : ''; ?>>Barangay SK Chairperson</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label for="office_start_date">Term Start:</label>
                                                                    <input type="date" class="form-control" name="office_start_date" value="<?= htmlspecialchars($officialData['office_start_date']) ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No officials found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Official Modal -->
    <div class="modal fade" id="addOfficialModal" tabindex="-1" aria-labelledby="addOfficialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOfficialModalLabel">Add Official</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/officials/submit_official.php" method="POST">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="resident-id">Resident:</label>
                                <select class="form-control" name="resident_id" required>
                                    <?php
                                    $residents = new Resident();
                                    $residents = $residents->getResidents();
                                    if (!empty($residents)) {
                                        foreach ($residents as $resident) {
                                            $resident_id = htmlspecialchars($resident['resident_id']);
                                            $official_check = new Official();
                                            $existingOfficial = $official_check->checkIfOfficial($resident_id);
                                            if (!$existingOfficial) {
                                                echo "<option value='" . htmlspecialchars($resident['resident_id']) . "'>(" . htmlspecialchars($resident['resident_id']) . ") " . htmlspecialchars($resident['first_name']) . " " . htmlspecialchars($resident['last_name']) . "</option>";
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="position">Position:</label>
                                <select class="form-control" id="position" name="position" required>
                                    <option value="Barangay Captain">Barangay Captain</option>
                                    <option value="Barangay Kagawad">Barangay Kagawad</option>
                                    <option value="Barangay Secretary">Barangay Secretary</option>
                                    <option value="Barangay Treasurer">Barangay Treasurer</option>
                                    <option value="Barangay Tanod">Barangay Tanod</option>
                                    <option value="Barangay Chairperson">Barangay Chairperson</option>
                                    <option value="Barangay SK Chairperson">Barangay SK Chairperson</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="office_start_date">Term Start:</label>
                                <input type="date" class="form-control" name="office_start_date" required>
                            </div>
                            <div class="row">

                            </div>
                            <!-- <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="termEnd">Term End:</label>
                                    <input type="date" class="form-control" name="termEnd" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="status">Status:</label>
                                    <select class="form-control" name="status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div> -->

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Add Official</button>
                                <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Cancel</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>