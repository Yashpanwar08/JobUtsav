<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Company Registration | JobUtsav</title>
    <link rel="icon" href="logof.png" sizes="192x192" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --orange: #f47b20;
            --orange2: #ff8a2a;

            --bg: #f6f7f9;
            --text: #0f172a;
            --muted: #64748b;

            --card: #ffffff;
            --shadow: 0 18px 45px rgba(2, 6, 23, .12);
            --radius: 18px;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            font-family: Poppins, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            color: var(--text);
            background:
                radial-gradient(900px 420px at 70% 10%, rgba(244, 123, 32, .12), transparent 60%),
                radial-gradient(700px 360px at 15% 25%, rgba(15, 23, 42, .08), transparent 55%),
                var(--bg);
            display: grid;
            place-items: center;
            padding: 28px 16px;
        }

        .wrap {
            width: min(620px, 100%);
        }

        .card {
            background: var(--card);
            border: 1px solid rgba(15, 23, 42, .10);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .cardTop {
            padding: 18px 18px 14px;
            border-bottom: 1px solid rgba(15, 23, 42, .06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .logoDot {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(244, 123, 32, .10);
            border: 1px solid rgba(244, 123, 32, .18);
            color: var(--orange);
            font-weight: 900;
            flex: 0 0 auto;
        }

        .brandText {
            min-width: 0;
        }

        .brandText b {
            display: block;
            font-size: 14px;
            letter-spacing: -.2px;
            line-height: 1.2;
        }

        .brandText span {
            display: block;
            font-size: 12px;
            color: var(--muted);
            font-weight: 700;
            line-height: 1.2;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 360px;
        }

        .statusPill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(2, 6, 23, .04);
            border: 1px solid rgba(2, 6, 23, .08);
            font-size: 12px;
            font-weight: 900;
            color: #334155;
            white-space: nowrap;
            flex: 0 0 auto;
        }

        .statusDot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, .16);
        }

        .cardBody {
            padding: 16px 18px 18px;
        }

        /* PHP output container */
        #statusBody {
            color: #0f172a;
            font-size: 14px;
            line-height: 1.8;
            font-weight: 700;
            word-break: break-word;
        }

        #statusBody p {
            margin: 10px 0 0;
            font-weight: 700;
            color: var(--muted);
            font-size: 13.5px;
            line-height: 1.75;
        }

        #statusBody a {
            text-decoration: none;
            display: inline-block;
            margin-top: 14px;
        }

        .msgTitle {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: -.2px;
            color: #0f172a;
        }

        /* Style existing <button> without changing your PHP structure */
        #statusBody button {
            border: none;
            background: linear-gradient(135deg, var(--orange), var(--orange2));
            color: #fff;
            font-weight: 900;
            font-size: 14px;
            padding: 12px 16px;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 14px 26px rgba(244, 123, 32, .22);
            transition: .15s ease;
            min-width: 220px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        #statusBody button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(244, 123, 32, .26);
        }

        #statusBody button:active {
            transform: translateY(0);
        }

        #statusBody button::before {
            content: "\2193";
            font-weight: 900;
            opacity: .95;
        }

        /* Error state */
        .isError .statusDot {
            background: #ef4444;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, .18);
        }

        .isError .statusPill {
            background: rgba(239, 68, 68, .08);
            border-color: rgba(239, 68, 68, .18);
            color: #991b1b;
        }

        .isError .logoDot {
            background: rgba(239, 68, 68, .10);
            border-color: rgba(239, 68, 68, .18);
            color: #ef4444;
        }

        .isError .msgTitle {
            color: #991b1b;
        }

        /* Mobile */
        @media (max-width: 640px) {
            body {
                padding: 18px 12px;
            }

            .cardTop {
                padding: 16px 14px 12px;
            }

            .cardBody {
                padding: 14px;
            }

            .brandText span {
                max-width: 220px;
            }

            #statusBody button {
                width: 100%;
                min-width: unset;
            }

            .msgTitle {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="card" id="resultCard">
            <div class="cardTop">
                <div class="brand">
                    <div class="logoDot">JU</div>
                    <div class="brandText">
                        <b>JobUtsav</b>
                        <span>Company Registration</span>
                    </div>
                </div>

                <div class="statusPill" id="statusPill">
                    <span class="statusDot"></span>
                    <span id="statusText">Status</span>
                </div>
            </div>

            <div class="cardBody">
                <div id="statusBody">

                    <?php
                    // Hide PHP/SQL internals from users
                    ini_set('display_errors', '0');
                    ini_set('display_startup_errors', '0');

                    // Prevent any accidental output from db.php (like "Local connection successful!")
                    ob_start();
                    include 'db.php';
                    ob_end_clean();

                    function friendlyCompanyError($conn, $e = null)
                    {
                        // Default friendly error
                        $msg = "Something went wrong. Please try again.";

                        // If it's a mysqli exception
                        if ($e instanceof mysqli_sql_exception) {
                            $code = (int) $e->getCode();
                            $raw = $e->getMessage();

                            // Duplicate key (email/phone unique)
                            if ($code === 1062 || stripos($raw, 'Duplicate entry') !== false) {
                                if (stripos($raw, 'email') !== false) {
                                    $msg = "This email is already registered. Please use another email.";
                                } elseif (stripos($raw, 'contact') !== false || stripos($raw, 'contact_no') !== false) {
                                    $msg = "This phone number is already registered. Please use another phone number.";
                                } else {
                                    $msg = "These details are already registered. Please try different details.";
                                }
                            }
                        }

                        // If using non-exception mode (query returned false)
                        if ($e === null && $conn instanceof mysqli) {
                            $errno = (int) $conn->errno;
                            $err = (string) $conn->error;

                            if ($errno === 1062 || stripos($err, 'Duplicate entry') !== false) {
                                if (stripos($err, 'email') !== false) {
                                    $msg = "This email is already registered. Please use another email.";
                                } elseif (stripos($err, 'contact') !== false || stripos($err, 'contact_no') !== false) {
                                    $msg = "This phone number is already registered. Please use another phone number.";
                                } else {
                                    $msg = "These details are already registered. Please try different details.";
                                }
                            }
                        }

                        // Keep output simple (your UI styles will format it)
                        echo "Error: " . $msg;
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $companyName = $_POST['companyName'] ?? '';
                        $hrName = $_POST['hrName'] ?? '';
                        $contact = $_POST['contact'] ?? '';
                        $email = $_POST['email'] ?? '';
                        $password = $_POST['password'] ?? '';
                        $jobRoles = $_POST['jobRoles'] ?? '';
                        $openings = $_POST['openings'] ?? 0;
                        $salary = $_POST['salary'] ?? '';
                        $location = $_POST['location'] ?? '';
                        $process = $_POST['process'] ?? '';
                        $requirements = $_POST['requirements'] ?? '';

                        // Hash password before saving
                        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                        // If mysqli is configured to throw exceptions, we catch and show friendly message
                        try {
                            // Prefer prepared statement (safer)
                            $stmt = $conn->prepare(
                                "INSERT INTO companies
          (company_name, hr_name, contact_no, email, password, job_roles, openings, salary_range, hiring_location, selection_process, requirements)
          VALUES (?,?,?,?,?,?,?,?,?,?,?)"
                            );

                            if (!$stmt) {
                                friendlyCompanyError($conn);
                            } else {
                                $stmt->bind_param(
                                    "ssssssissss",
                                    $companyName,
                                    $hrName,
                                    $contact,
                                    $email,
                                    $hashedPassword,
                                    $jobRoles,
                                    $openings,
                                    $salary,
                                    $location,
                                    $process,
                                    $requirements
                                );

                                $ok = $stmt->execute();
                                if ($ok) {
                                    // Get company_id
                                    $lastUserId = $conn->insert_id;

                                    // Insert into registrations table
                                    $userType = "company";
                                    $stmtReg = $conn->prepare("INSERT INTO registrations (user_type, user_ref_id) VALUES (?, ?)");
                                    if ($stmtReg) {
                                        $stmtReg->bind_param("si", $userType, $lastUserId);
                                        $stmtReg->execute();

                                        // Generate Registration Code
                                        $newRegId = $conn->insert_id;
                                        $regCode = "JUGN" . $newRegId;

                                        // Update reg_code
                                        $stmtUp = $conn->prepare("UPDATE registrations SET reg_code=? WHERE reg_id=?");
                                        if ($stmtUp) {
                                            $stmtUp->bind_param("si", $regCode, $newRegId);
                                            $stmtUp->execute();
                                        }

                                        // Success message + Gatepass button (kept same output structure)
                                        echo "Company Registered Successfully!";
                                        echo "<br><p>Download your gatepass from here:</p>";
                                        echo "<a href='company_gatepass.php?reg_id=$regCode'><button>Download Gatepass</button></a>";
                                        //  NEW BUTTON (Index Page)
                                        echo "<br><a href='index.html'><button>Go to Home</button></a>";
                                    } else {
                                        // If registration insert fails, still show friendly error
                                        friendlyCompanyError($conn);
                                    }

                                } else {
                                    // Non-exception mode error
                                    friendlyCompanyError($conn);
                                }
                            }

                        } catch (mysqli_sql_exception $e) {
                            // Friendly message only (no stack trace)
                            friendlyCompanyError($conn, $e);
                        } catch (Throwable $e) {
                            // Any other unexpected error
                            echo "Error: Something went wrong. Please try again.";
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Modern formatting without changing PHP echo text:
        // - Convert first plain text line into a title
        // - Detect "Error:" and switch to error UI
        (function () {
            const card = document.getElementById('resultCard');
            const body = document.getElementById('statusBody');
            const statusText = document.getElementById('statusText');
            if (!body) return;

            const rawText = (body.innerText || '').trim();
            const isError = rawText.startsWith('Error:') || rawText.includes('\nError:') || rawText.includes('Error: ');
            if (isError) {
                card.classList.add('isError');
                if (statusText) statusText.textContent = 'Failed';
            } else {
                if (statusText) statusText.textContent = 'Success';
            }

            // Turn first non-empty text node into a styled title
            const nodes = Array.from(body.childNodes);
            let firstTextNode = null;
            for (const n of nodes) {
                if (n.nodeType === Node.TEXT_NODE && n.textContent.trim().length) {
                    firstTextNode = n;
                    break;
                }
            }

            if (firstTextNode) {
                const title = document.createElement('h1');
                title.className = 'msgTitle';
                title.textContent = firstTextNode.textContent.trim();

                body.removeChild(firstTextNode);

                // remove leading <br> if present
                if (body.firstChild && body.firstChild.nodeName === 'BR') {
                    body.removeChild(body.firstChild);
                }

                body.insertBefore(title, body.firstChild);
            }
        })();
    </script>
</body>

</html>