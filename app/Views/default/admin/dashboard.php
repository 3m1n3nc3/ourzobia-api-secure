			<div class="row"> 
				<!-- /.col -->
				<div class="col-12 col-md-4">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-light elevation-1"><i class="fas fa-fw fa-box"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">All Products</span>
							<span class="info-box-number">
								 <?=$statistics['all_products']??0?>
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-12 col-md-4">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-light elevation-1"><i class="fas fa-fw fa-box-open"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Active Products</span>
							<span class="info-box-number">
								 <?=$statistics['active_products']??0?>
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-12 col-md-4">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-light elevation-1"><i class="fas fa-fw fa-users"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">All Users</span>
							<span class="info-box-number">
								 <?=$statistics['all_users']??0?>
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row --> 

    		<!-- Main content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-6" id="chart_users">
							<div class="card"> 
								<div class="card-header border-0">
									<h3 class="card-title">
										<i class="fas fa-users mr-1"></i>
										Recent Registrations 
										<span class="text-success">
											<i class="fas fa-arrow-up"></i> <span class="users_data_set"></span>
										</span>   
									</h3>
									<!-- card tools -->
									<div class="card-tools">
										<button type="button"
										class="btn btn-secondary btn-sm daterange"
										data-chart="users"
										data-toggle="tooltip"
										title="Date range">
										<i class="far fa-calendar-alt"></i>
										</button>
									</div>
									<!-- /.card-tools -->
								</div>
								<div class="card-body">  
									<div class="position-relative mb-4">
										<canvas id="recent-reg-chart" height="200"></canvas>
									</div> 
								</div>
							</div>
							<!-- /.card -->
						</div>
						<div class="col-lg-6" id="chart_visitors">
							<div class="card"> 
								<div class="card-header border-0">
									<h3 class="card-title">
										<i class="fa fa-user-secret mr-1"></i>
										Recent Visitors 
										<span class="text-success">
											<i class="fas fa-arrow-up"></i> <span class="visitors_data_set"></span>
										</span>   
									</h3>
									<!-- card tools -->
									<div class="card-tools">
										<button type="button"
										class="btn btn-secondary btn-sm daterange"
										data-chart="visit"
										data-toggle="tooltip"
										title="Date range">
										<i class="far fa-calendar-alt"></i>
										</button>
									</div>
									<!-- /.card-tools -->
								</div>
								<div class="card-body">  
									<div class="position-relative mb-4">
										<canvas id="monthly-visitors-chart" height="200"></canvas>
									</div> 
								</div>
							</div>
							<!-- /.card -->
						</div>
						<div class="col-lg-6" id="chart_visitors">
							<div class="card"> 
								<div class="card-header border-0">
									<h3 class="card-title">
										<i class="fa fa-check mr-1"></i>
										Recent Activations 
										<span class="text-success">
											<i class="fas fa-arrow-up"></i> <span class="activation_data_set"></span>
										</span>   
									</h3>
									<!-- card tools -->
									<div class="card-tools">
										<button type="button"
										class="btn btn-secondary btn-sm daterange"
										data-chart="activation"
										data-toggle="tooltip"
										title="Date range">
										<i class="far fa-calendar-alt"></i>
										</button>
									</div>
									<!-- /.card-tools -->
								</div>
								<div class="card-body">  
									<div class="position-relative mb-4">
										<canvas id="monthly-activation-chart" height="200"></canvas>
									</div> 
								</div>
							</div>
							<!-- /.card -->
						</div>
						<div class="col-lg-6" id="chart_visitors">
							<div class="card"> 
								<div class="card-header border-0">
									<h3 class="card-title">
										<i class="fa fa-check-circle mr-1"></i>
										Recent Validations 
										<span class="text-success">
											<i class="fas fa-arrow-up"></i> <span class="validation_data_set"></span>
										</span>   
									</h3>
									<!-- card tools -->
									<div class="card-tools">
										<button type="button"
										class="btn btn-secondary btn-sm daterange"
										data-chart="validation"
										data-toggle="tooltip"
										title="Date range">
										<i class="far fa-calendar-alt"></i>
										</button>
									</div>
									<!-- /.card-tools -->
								</div>
								<div class="card-body">  
									<div class="position-relative mb-4">
										<canvas id="monthly-validation-chart" height="200"></canvas>
									</div> 
								</div>
							</div>
							<!-- /.card -->
						</div>
					</div>
				</div>
			</div> 
