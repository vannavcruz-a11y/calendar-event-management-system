<style>
.create-event-container {
    max-width: 700px;
    margin: 40px auto;
    padding: 30px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.05);
}

.page-title {
    font-size: 28px;
    color: #333;
    margin-bottom: 25px;
    text-align: center;
}

.event-form label {
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
    color: #555;
    font-weight: 500;
}

.event-form input[type="text"],
.event-form input[type="date"],
.event-form input[type="time"],
.event-form input[type="file"],
.event-form textarea {
    width: 100%;
    padding: 10px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 15px;
    transition: 0.3s;
}

.event-form input:focus,
.event-form textarea:focus {
    border-color: #3498db;
    outline: none;
}

.event-form textarea {
    min-height: 100px;
    resize: vertical;
}

.form-row {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.form-group {
    flex: 1;
}

.form-actions {
    margin-top: 25px;
    display: flex;
    gap: 15px;
}

.btn-primary,
.btn-secondary {
    display: inline-block;
    padding: 10px 25px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: 0.3s;
    text-align: center;
}

.btn-primary {
    background-color: #27ae60;
    color: #fff;
}

.btn-primary:hover {
    background-color: #1e8449;
}

.btn-secondary {
    background-color: #3498db;
    color: #fff;
}

.btn-secondary:hover {
    background-color: #2980b9;
}
</style>

<?= $this->include('templates/header') ?>

<div class="create-event-container">
    <h2 class="page-title">Create Event</h2>

    <form method="post" action="<?= base_url('campus/event/store') ?>" enctype="multipart/form-data" class="event-form">
        <input type="hidden" name="campus_id" value="<?= $campus_id ?>">

        <label for="org_name">Organisation Name</label>
        <input type="text" id="org_name" name="org_name" placeholder="Organisation Name" required>

        <label for="title">Event Title</label>
        <input type="text" id="title" name="title" placeholder="Event Title" required>

        <label for="description">Event Description</label>
        <textarea id="description" name="description" placeholder="Event Description"></textarea>

        <div class="form-row">
            <div class="form-group">
                <label for="date">Event Date</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time_in">Time In</label>
                <input type="time" id="time_in" name="time_in" required>
            </div>
            <div class="form-group">
                <label for="time_out">Time Out</label>
                <input type="time" id="time_out" name="time_out" required>
            </div>
        </div>

        <label for="location">Location</label>
        <input type="text" id="location" name="location" placeholder="Location" required>

        <label for="poster">Poster (optional)</label>
        <input type="file" id="poster" name="poster">

        <div class="form-actions">
            <button type="submit" class="btn-primary">Save Event</button>
            <a href="<?= base_url('campus/'.$campus_id) ?>" class="btn-secondary">Back</a>
        </div>
    </form>
</div>

<?= $this->include('templates/footer') ?>
