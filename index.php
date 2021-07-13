<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <link rel="stylesheet" media="screen and (min-width: 700px)" href="./lib/styles/style.desktop.css?v=3" /> -->
    <link rel="stylesheet" href="./lib/styles/style.desktop.css?v=5" />
    <link rel="stylesheet" media="screen and (max-width: 700px)" href="./lib/styles/style.mobile.css?v=3" />
    <title>RRM PHP FORM</title>
</head>
<body>
    <div class="container">
        <form>
            <div class="row">
                <div class="col">
                    <label>First name</label><input type="text" name="fname" required>
                </div>
                <div class="col">
                    <label>Last name</label><input type="text" name="lname" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Email address</label><input type="email" name="email" required>
                </div>
                <div class="col">
                    <label>Telephone number</label><input type="tel" name="tel" required>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Address 1</label>
                    <input type="text" name="address_1" required>
                </div>
                <div class="col">
                    <label>Address 2</label>
                    <input type="text" name="address_2">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Town</label>
                    <input type="text" name="town" required>
                </div>
                <div class="col">
                    <label>County</label>
                    <input type="text" name="county">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label>Postcode</label>
                    <input type="text" name="postcode" required>
                </div>
                <div class="col">
                    <label>Country</label>
                    <div class="select">
                        <select name="country" required>
                            <option value="">Select country...</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="United States">United States</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Description</label>
                    <textarea name="description"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Your C.V</label>
                    <div class="row">
                        <span style="margin-right: 10px;">Select a file</span> <input type="file" name="cv" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="submit">Submit</button>
        </form>
    </div>
</body>
</html>