<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATM Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">ATM Site Information</h2>
    <form>

        <!-- ATM ID -->
        <div class="mb-3">
            <label for="atmId" class="form-label">ATM ID *</label>
            <input type="text" class="form-control" id="atmId" required>
        </div>

        <!-- Bank Selection -->
        <div class="mb-3">
            <label for="bank" class="form-label">Bank *</label>
            <select class="form-select" id="bank" required>
                <option value="">Select Bank</option>
                <option>AXIS</option>
                <option>BOI</option>
                <option>HDFC</option>
                <option>ICICI</option>
                <option>IDFC</option>
                <option>Indusind</option>
                <option>PNB</option>
                <option>RBL</option>
                <option>SBI BANK</option>
            </select>
        </div>

        <!-- Customer Name -->
        <div class="mb-3">
            <label for="customerName" class="form-label">Customer Name *</label>
            <select class="form-select" id="customerName" required>
                <option value="">Select Customer</option>
                <option>Euronet</option>
                <option>Diebold</option>
                <option>Hitachi</option>
                <option>FSS</option>
            </select>
        </div>

        <!-- Router Name -->
        <div class="mb-3">
            <label for="routerName" class="form-label">Router Name *</label>
            <select class="form-select" id="routerName" required>
                <option value="">Select Router</option>
                <option>Techroute 3G</option>
                <option>Techroute 4G</option>
                <option>Credo</option>
                <option>Maipu</option>
                <option>Gigatek</option>
                <option>3G+OD</option>
            </select>
        </div>

        <!-- Antenna Installed -->
        <div class="mb-3">
            <label for="antennaType" class="form-label">Which Type of Antenna Installed on Site *</label>
            <select class="form-select" id="antennaType" required>
                <option value="">Select Antenna Type</option>
                <option>Yagi Antenna</option>
                <option>Omini Antenna</option>
                <option>Patch Antenna</option>
                <option>Out Door Unit</option>
                <option>Dbi Antenna</option>
            </select>
        </div>

        <!-- Panel Name -->
        <div class="mb-3">
            <label for="panelName" class="form-label">Panel Name *</label>
            <select class="form-select" id="panelName" required>
                <option value="">Select Panel</option>
                <option>RASS</option>
                <option>SMART-I</option>
                <option>SMART-IN</option>
                <option>SECURICO 1616</option>
                <option>SECURICO 4816</option>
                <option>Comfort</option>
            </select>
        </div>

        <!-- DVR/NVR Make -->
        <div class="mb-3">
            <label for="dvrNvrMake" class="form-label">DVR/NVR Make *</label>
            <select class="form-select" id="dvrNvrMake" required>
                <option value="">Select DVR/NVR Make</option>
                <option>CP PLUS ORANGE</option>
                <option>CP PLUS INDIGO</option>
                <option>DAHUVA NVR</option>
                <option>DAHUVA XVR</option>
                <option>DAHUVA DVR</option>
                <option>HIKVISION DVR</option>
                <option>HIKVISION NVR</option>
                <option>UNV XVR</option>
                <option>UNV NVR</option>
            </select>
        </div>

        <!-- DVR/NVR/XVR Status -->
        <div class="mb-3">
            <label for="dvrNvrStatus" class="form-label">DVR/NVR/XVR *</label>
            <select class="form-select" id="dvrNvrStatus" required>
                <option value="">Select Status</option>
                <option>Working</option>
                <option>Not Working</option>
                <option>Not Install</option>
                <option>Missing</option>
                <option>Not Required</option>
            </select>
        </div>

        <!-- Camera 1 Status -->
        <div class="mb-3">
            <label for="camera1Status" class="form-label">Camera 1 *</label>
            <select class="form-select" id="camera1Status" required>
                <option value="">Select Status</option>
                <option>Working</option>
                <option>Not Working</option>
                <option>Not Install</option>
                <option>Missing</option>
            </select>
        </div>

        <!-- Add more form fields similarly as per the requirement -->

        <!-- Upload live snaps -->
        <div class="mb-3">
            <label for="liveSnaps" class="form-label">Live Snaps *</label>
            <input type="file" class="form-control" id="liveSnaps" accept="image/*" required>
        </div>

        <!-- Test Done By -->
        <div class="mb-3">
            <label for="testDoneBy" class="form-label">Test Done By *</label>
            <input type="text" class="form-control" id="testDoneBy" required>
        </div>

        <!-- Remarks -->
        <div class="mb-3">
            <label for="remarks" class="form-label">Remarks</label>
            <textarea class="form-control" id="remarks" rows="3"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
