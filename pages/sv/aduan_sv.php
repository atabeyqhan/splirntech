<?php
session_start();
$_POST['sv_id'] = $_SESSION['sv_id'];
$sv_id = $_POST['sv_id'];
include "../conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SPLI RN TECH | Senarai Pelajar</title>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<link rel="stylesheet" href="../../dist/css/adminlte.min.css">
	<link rel="stylesheet" href="../../dist/css/alt/splicss.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="../../plugins/jquery/jquery.min.js"></script>
	<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="../../plugins/jszip/jszip.min.js"></script>
	<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<script src="../../dist/js/adminlte.min.js"></script>
	<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">

		<!-- Loading indicator -->
		<div class="preloader flex-column justify-content-center align-items-center">
			<img src="/splirnt/assets/img/loading.png" alt="Loading..." class="spinning-image">
		</div>



		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<?php
		include("includes/navbar.php");
		?>

		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<?php
		include("includes/mainsidebar.php");
		?>

		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Aduan</h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="dashboard_sv.php">Laman Utama</a></li>
								<li class="breadcrumb-item active">Aduan</li>
							</ol>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<section class="content">
				<div class="container-fluid">
					<div class="card card-warning">
						<div class="card-header">
							<h3 class="card-title">Aduan Baru</h3>
						</div>

						<!-- form start -->
						<?php
						// Fetch student names from the database
						$query = "SELECT student.id AS studID, student.name AS studName, supervisor.name AS svname FROM student JOIN supervisor WHERE student.status ='Aktif' AND supervisor.sv_id ='" . $sv_id . "'";
						$result = $conn->query($query);

						// Check if there are rows returned
						if ($result->num_rows > 0) {
							// Store student names in an array
							$students = array();
							while ($row = $result->fetch_assoc()) {
								$students[] = $row["studName"];
								$svname = $row["svname"];
							}
						} else {
							// Handle the case when no students are found
							echo "No students found in the database.";
						}
						?>

						<!-- ./card-header -->
						<div class="card-body">
							<div class="table-responsive">
								<form id="formID" method='post' action='addFeedback_svDB.php'>
									<div class="form-group">
										<p>
											<label for="name">Pengadu</label>
											<input class="form-control" name="pengadu" id="pengadu" value="<?php echo $svname; ?>" readonly>
										</p>
										<p>
											<label for="date">Nama Pelajar*</label>
											<select name="studentName" id="studentName" class="form-control" required>
												<option value=""> -- Pilih Nama Pelajar -- </option>
												<?php
												// Populate dropdown with student names
												foreach ($students as $student) {
													echo "<option value=\"$student\">$student</option>";
												}
												?>
											</select>

										</p>
										<p>
											<?php
											date_default_timezone_set('Asia/Kuala_Lumpur');
											$Date = gmdate('Y-m-d');
											$currenttime = date('h:i A');
											?>
											<label for="aduan">Aduan*</label>
											<input class="form-control" name="aduan" id="aduan" placeholder="Aduan yang ingin dikenakan" required>
										</p>
										<p>
											<label for="date">Tarikh Aduan*</label>
											<input type="form-control" class="form-control" value="<?php echo date('d/m/Y', strtotime($Date)); ?>" readonly>
											<input type="hidden" name="date" id="date" value="<?php echo $Date; ?>">
										</p>
										<p>
											<label for="masa">Masa Aduan*</label>
											<input type="form-control" class="form-control" name="time" id="time" value="<?php echo $currenttime; ?>" placeholder="<?php echo $currenttime; ?>" readonly>
										</p>
										<p>
											<label for="type">Jenis Aduan*</label>
											<select name="type" id="type" class="form-control" required>
												<option value=""> -- Pilih Jenis Aduan -- </option>
												<option value="Maklumbalas"> Maklumbalas </option>
												<option value="Aduan"> Aduan </option>
											</select>
										</p>
										<p>
											<input type='submit' name='submit' value='Simpan' class='btn btn-danger' onclick='return confirmUpdate()'>
										</p>
									</div>
								</form>
							</div> <!-- END OF FORM -->
						</div>

						<!-- /.card -->
					</div>
					<!-- /.container-fluid -->
			</section>

			<section class="content">
				<div class="container-fluid">
					<div class="card card-navy">
						<div class="card-header">
							<h3 class="card-title">Senarai Sejarah Aduan</h3>
						</div>
						<div class="row mt-4">
							<div class="col-md-3 ml-3">
								<!-- "Show Entries" dropdown -->
								<label for="entriesDropdown">Papar:</label>
								<select id="entriesDropdown">
									<option value="5" selected>5</option>
									<option value="10">10</option>
									<option value="25">25</option>
									<option value="50">50</option>
								</select>
							</div>
						</div>
						<!-- ./card-header -->
						<div class="card-body">
							<table id="example2" class="table table-bordered table-striped">
								<thead>
									<tr style="text-align:center">
										<th>Bil.</th>
										<th>Nama Pelajar</th>
										<th>Aduan</th>
										<th>Tarikh Aduan</th>
										<th>Masa Aduan</th>
										<th>Jenis Aduan</th>
										<th>Status</th>
									</tr>
								</thead>


								<tbody>
									<?php
									$i = 1;
									$query = "SELECT * FROM feedback where pekerja_id ='" . $sv_id . "'";
									$result = $conn->query($query);

									if ($result->num_rows > 0) {
										while ($row = $result->fetch_assoc()) {
											echo "<tr>";
											echo "<td>" . $i++ . "</td>";
											echo "<td>" . $row["person_name"] . "</td>";
											echo "<td>" . $row["description"] . "</td>";
											echo "<td>" .  date('d/m/Y', strtotime($row['date'])) . "</td>";
											echo "<td>" .  date('h:i A', strtotime($row['time'])) . "</td>";
											echo "<td>" . $row["feedback_type"] . "</td>";
											echo "<td>" . $row["status"] . "</td>";
											echo "</tr>";
										}
									} else {
										echo "<tr style='text-align:center'><td colspan='6'>Tiada Rekod</td></tr>";
									}

									?>
								</tbody>
							</table>
						</div>

						<!-- /.card -->
					</div>
					<!-- /.container-fluid -->
			</section>

			<div class="card-body">
				<div class="table-responsive">
				</div>

			</div><!-- /.card-body -->

		</div>

		<?php
		include("includes/footer.php");
		?>

		<aside class="control-sidebar control-sidebar-dark">
		</aside>
	</div>


	<!-- Page specific script -->
	<script>
		$(function() {
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"buttons": ["excel", "pdf", "colvis"]
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

			var table = $('#example2').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				"pageLength": 5,
				"responsive": true,
			});
			// Reinitialize DataTable when "Show Entries" dropdown changes
			$('#entriesDropdown').on('change', function() {
				var entries = $(this).val();
				table.page.len(entries).draw();
			});
		});
	</script>

	<!-- <script>
$(document).ready(function() {
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "dom": 'Bfrtip',
        "buttons": [
            'excel', 'pdf'
        ]
    });
}); -->
	</script>


</body>

</html>