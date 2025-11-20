<!-- [ Main Content ] start -->
<div class="row">
    <!-- Revenue Stats -->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header px-4 pt-4 pb-0">
                <h5 class="mb-0">Payment Records</h5>
                <div class="d-flex align-items-center justify-content-between mt-3">
                    <p class="fs-13 fw-semibold text-muted mb-0">Monthly revenue statistics</p>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-light-primary">Monthly</button>
                        <button class="btn btn-sm btn-light">Weekly</button>
                        <button class="btn btn-sm btn-light">Daily</button>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div id="payment-records-chart"></div>
            </div>
        </div>
    </div>

    <!-- Summary Cards Row -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Total Sales</h6>
                    <span class="badge bg-success-subtle text-success">+2.5%</span>
                </div>
                <div id="total-sales-color-graph"></div>
                <div class="d-flex align-items-center justify-content-between mt-4">
                    <h4 class="mb-0 fw-medium">$28,947</h4>
                    <span class="fs-13 text-success">
                        <i class="feather-arrow-up me-1"></i>
                        12.5%
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Tasks Completed</h6>
                    <span class="badge bg-primary-subtle text-primary">+5.7%</span>
                </div>
                <div id="task-completed-area-chart"></div>
                <div class="d-flex align-items-center justify-content-between mt-4">
                    <h4 class="mb-0 fw-medium">847</h4>
                    <span class="fs-13 text-primary">
                        <i class="feather-arrow-up me-1"></i>
                        8.2%
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">New Tasks</h6>
                    <span class="badge bg-warning-subtle text-warning">-1.2%</span>
                </div>
                <div id="new-tasks-area-chart"></div>
                <div class="d-flex align-items-center justify-content-between mt-4">
                    <h4 class="mb-0 fw-medium">385</h4>
                    <span class="fs-13 text-warning">
                        <i class="feather-arrow-down me-1"></i>
                        3.8%
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Charts Row -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header px-4 pt-4 pb-0">
                <h5 class="mb-0">Project Progress</h5>
                <div class="d-flex align-items-center justify-content-between mt-3">
                    <p class="fs-13 fw-semibold text-muted mb-0">Progress across all active projects</p>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center project-progress-1" data-value="0.4" data-thickness="5" data-empty-fill="#E1E3EA" data-fill="{&quot;color&quot;: &quot;#3454d1&quot;}" style="width: 120px; margin: 0 auto;">
                            <strong>40%</strong>
                            <h6 class="mt-3">Project A</h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center project-progress-2" data-value="0.65" data-thickness="5" data-empty-fill="#E1E3EA" data-fill="{&quot;color&quot;: &quot;#25b865&quot;}" style="width: 120px; margin: 0 auto;">
                            <strong>65%</strong>
                            <h6 class="mt-3">Project B</h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center project-progress-3" data-value="0.50" data-thickness="5" data-empty-fill="#E1E3EA" data-fill="{&quot;color&quot;: &quot;#d13b4c&quot;}" style="width: 120px; margin: 0 auto;">
                            <strong>50%</strong>
                            <h6 class="mt-3">Project C</h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center project-progress-4" data-value="0.75" data-thickness="5" data-empty-fill="#E1E3EA" data-fill="{&quot;color&quot;: &quot;#ffa726&quot;}" style="width: 120px; margin: 0 auto;">
                            <strong>75%</strong>
                            <h6 class="mt-3">Project D</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header px-4 pt-4 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Leads Overview</h5>
                    <div class="dropdown">
                        <a href="#" class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                            <i class="feather-more-horizontal"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Daily</a>
                            <a class="dropdown-item" href="#">Weekly</a>
                            <a class="dropdown-item" href="#">Monthly</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <div id="leads-overview-donut"></div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->