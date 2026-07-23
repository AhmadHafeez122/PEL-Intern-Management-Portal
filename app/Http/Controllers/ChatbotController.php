<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Supervisor;
use App\Models\Intern;
use App\Models\Attendance;
use App\Models\Task;
use App\Models\Announcement;

class ChatbotController extends Controller
{
    /**
     * PEL Internship Portal — AI Chatbot Handler
     *
     * Processes user messages and returns intelligent, context-aware responses
     * powered by REAL portal data (departments, supervisors, interns, etc.)
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = strtolower(trim($request->input('message')));
        $response = $this->generateResponse($userMessage);

        return response()->json([
            'reply' => $response['text'],
            'suggestions' => $response['suggestions'] ?? [],
        ]);
    }

    // =====================================================================
    //  LIVE DATA FETCHERS — Pull real stats from your portal database
    // =====================================================================

    private function getPortalStats(): array
    {
        return [
            'total_interns'       => Intern::count(),
            'active_interns'      => Intern::where('status', 'Active')->count(),
            'pending_interns'     => Intern::where('status', 'Pending')->count(),
            'completed_interns'   => Intern::where('status', 'Completed')->count(),
            'rejected_interns'    => Intern::where('status', 'Rejected')->count(),
            'total_supervisors'   => Supervisor::count(),
            'active_supervisors'  => Supervisor::where('is_active', true)->count(),
            'total_departments'   => Department::count(),
            'total_tasks'         => Task::count(),
            'pending_tasks'       => Task::where('status', 'Pending')->count(),
            'in_progress_tasks'   => Task::where('status', 'In Progress')->count(),
            'completed_tasks'     => Task::where('status', 'Completed')->count(),
            'total_applications'  => DB::table('applications')->count(),
            'pending_applications'=> DB::table('applications')->where('status', 'Pending')->count(),
            'approved_applications'=> DB::table('applications')->where('status', 'Active')->count(),
            'rejected_applications'=> DB::table('applications')->where('status', 'Rejected')->count(),
        ];
    }

    private function getDepartmentList(): array
    {
        return Department::withCount(['interns', 'supervisors'])->get()->map(function ($dept) {
            return [
                'name'             => $dept->name,
                'interns_count'    => $dept->interns_count,
                'supervisors_count'=> $dept->supervisors_count,
            ];
        })->toArray();
    }

    private function getSupervisorList(): array
    {
        return Supervisor::with('department')->withCount('interns')->where('is_active', true)->get()->map(function ($sup) {
            return [
                'name'          => $sup->name,
                'email'         => $sup->email,
                'department'    => $sup->department->name ?? 'Unassigned',
                'interns_count' => $sup->interns_count,
            ];
        })->toArray();
    }

    private function getAttendanceStats(): array
    {
        $total   = Attendance::count();
        $present = Attendance::where('status', 'Present')->count();
        $absent  = Attendance::where('status', 'Absent')->count();
        $leave   = Attendance::where('status', 'Leave')->count();

        return [
            'total'      => $total,
            'present'    => $present,
            'absent'     => $absent,
            'leave'      => $leave,
            'percentage' => $total > 0 ? round(($present / $total) * 100) : 0,
        ];
    }

    private function getLatestAnnouncements(): array
    {
        return Announcement::latest()->take(5)->get()->map(function ($a) {
            return [
                'title' => $a->title,
                'body'  => \Illuminate\Support\Str::limit($a->body, 120),
                'date'  => $a->created_at?->format('M d, Y') ?? 'N/A',
            ];
        })->toArray();
    }

    // =====================================================================
    //  RESPONSE GENERATOR — Matches intent and injects live data
    // =====================================================================

    private function generateResponse(string $message): array
    {
        // ── Greeting patterns ──────────────────────────────────────────
        if (preg_match('/\b(hi|hello|hey|assalam|salam|good morning|good evening|good afternoon)\b/', $message)) {
            $stats = $this->getPortalStats();
            return [
                'text' => "Hello! 👋 Welcome to the **PEL Internship Portal**. I'm your AI assistant powered by real portal data.\n\n📊 **Live Portal Snapshot:**\n• **{$stats['total_interns']}** registered interns\n• **{$stats['active_supervisors']}** active supervisors\n• **{$stats['total_departments']}** departments\n• **{$stats['pending_applications']}** pending applications\n\nHow can I help you today?",
                'suggestions' => ['Show departments', 'Show supervisors', 'Application process', 'Portal statistics'],
            ];
        }

        // ── Portal Statistics ──────────────────────────────────────────
        if (preg_match('/\b(statistic|stats|numbers|overview|summary|dashboard|how many|total|count)\b/', $message)) {
            $stats = $this->getPortalStats();
            $att   = $this->getAttendanceStats();
            return [
                'text' => "📊 **Live Portal Statistics:**\n\n👥 **Interns:**\n• Total: **{$stats['total_interns']}**\n• Active: **{$stats['active_interns']}** | Pending: **{$stats['pending_interns']}**\n• Completed: **{$stats['completed_interns']}** | Rejected: **{$stats['rejected_interns']}**\n\n👨‍🏫 **Supervisors:** **{$stats['active_supervisors']}** active out of **{$stats['total_supervisors']}**\n\n🏢 **Departments:** **{$stats['total_departments']}**\n\n📋 **Tasks:**\n• Total: **{$stats['total_tasks']}**\n• Pending: **{$stats['pending_tasks']}** | In Progress: **{$stats['in_progress_tasks']}** | Completed: **{$stats['completed_tasks']}**\n\n📝 **Applications:**\n• Total: **{$stats['total_applications']}**\n• Pending: **{$stats['pending_applications']}** | Approved: **{$stats['approved_applications']}** | Rejected: **{$stats['rejected_applications']}**\n\n✅ **Attendance Rate:** **{$att['percentage']}%** ({$att['present']} present out of {$att['total']} records)",
                'suggestions' => ['Show departments', 'Show supervisors', 'How to apply?', 'Announcements'],
            ];
        }

        // ── Department listing ─────────────────────────────────────────
        if (preg_match('/\b(department|departments|division|divisions|branch|section)\b/', $message)) {
            $departments = $this->getDepartmentList();
            if (empty($departments)) {
                return [
                    'text' => "🏢 No departments have been created in the portal yet. The admin will set them up soon!",
                    'suggestions' => ['Portal statistics', 'How to apply?', 'Show supervisors'],
                ];
            }
            $deptText = "🏢 **Available Departments ({$this->count($departments)}):**\n\n";
            foreach ($departments as $i => $d) {
                $num = $i + 1;
                $deptText .= "**{$num}. {$d['name']}**\n→ {$d['interns_count']} intern(s) • {$d['supervisors_count']} supervisor(s)\n\n";
            }
            $deptText .= "Each department has dedicated supervisors who mentor and guide interns throughout the program.";
            return [
                'text' => $deptText,
                'suggestions' => ['Show supervisors', 'Portal statistics', 'How to apply?'],
            ];
        }

        // ── Supervisor listing ─────────────────────────────────────────
        if (preg_match('/\b(supervisor|supervisors|mentor|mentors|guide|assigned)\b/', $message)) {
            $supervisors = $this->getSupervisorList();
            if (empty($supervisors)) {
                return [
                    'text' => "👨‍🏫 No active supervisors found in the portal yet. They will be assigned once departments are set up.",
                    'suggestions' => ['Show departments', 'Portal statistics', 'How to apply?'],
                ];
            }
            $supText = "👨‍🏫 **Active Supervisors ({$this->count($supervisors)}):**\n\n";
            foreach ($supervisors as $i => $s) {
                $num = $i + 1;
                $supText .= "**{$num}. {$s['name']}**\n→ Department: {$s['department']} • Managing {$s['interns_count']} intern(s)\n→ ✉️ {$s['email']}\n\n";
            }
            return [
                'text' => $supText,
                'suggestions' => ['Show departments', 'Portal statistics', 'How to apply?'],
            ];
        }

        // ── Intern listing / status ────────────────────────────────────
        if (preg_match('/\b(intern|interns|students|registered|enrolled|active intern|list of intern)\b/', $message)) {
            $stats = $this->getPortalStats();
            $recentInterns = Intern::with(['department', 'supervisor'])->latest()->take(5)->get();

            $internText = "👥 **Intern Overview:**\n\n• Total Registered: **{$stats['total_interns']}**\n• Active: **{$stats['active_interns']}** | Pending: **{$stats['pending_interns']}**\n• Completed: **{$stats['completed_interns']}** | Rejected: **{$stats['rejected_interns']}**\n\n";

            if ($recentInterns->count() > 0) {
                $internText .= "📋 **Recent Interns:**\n\n";
                foreach ($recentInterns as $i => $intern) {
                    $num = $i + 1;
                    $dept = $intern->department->name ?? 'Unassigned';
                    $sup  = $intern->supervisor->name ?? 'Not Assigned';
                    $internText .= "**{$num}. {$intern->name}**\n→ {$intern->university} • Dept: {$dept}\n→ Supervisor: {$sup} • Status: **{$intern->status}**\n\n";
                }
            }
            return [
                'text' => $internText,
                'suggestions' => ['Show departments', 'Show supervisors', 'Application status', 'Portal statistics'],
            ];
        }

        // ── Application process / How to apply ─────────────────────────
        if (preg_match('/\b(how.*(apply|register|submit)|application process|steps|procedure|sign up|apply)\b/', $message)) {
            $stats = $this->getPortalStats();
            $departments = $this->getDepartmentList();
            $deptNames = array_column($departments, 'name');
            $deptList = !empty($deptNames) ? implode(', ', $deptNames) : 'To be announced';

            return [
                'text' => "🚀 **How to Apply — Step by Step:**\n\n**Step 1: Create an Account**\n→ [Register here](/register) with your name, email & password\n\n**Step 2: Fill Application Form**\nYou'll need to provide:\n• **University/Institution** name\n• **Department** (options: {$deptList})\n• **Registration Number** (unique ID, e.g., PEL-6583)\n• **CV/Resume** upload (PDF or DOCX, max 2MB)\n\n**Step 3: Wait for Admin Review**\n→ Your application status will be **Pending** until reviewed\n→ Currently **{$stats['pending_applications']}** applications are pending review\n\n**Step 4: Get Approved & Start**\n→ Once approved, you become an **Active** intern\n→ A supervisor and department will be assigned to you\n\n📌 Currently **{$stats['approved_applications']}** applications have been approved!",
                'suggestions' => ['Create my account', 'What documents needed?', 'Show departments', 'Application status'],
            ];
        }

        // ── Application status ─────────────────────────────────────────
        if (preg_match('/\b(application.*(status|track|check|pending|approved|rejected)|status.*application|my application|track)\b/', $message)) {
            $stats = $this->getPortalStats();
            return [
                'text' => "📝 **Application Status Overview:**\n\n• **Total Applications:** {$stats['total_applications']}\n• ⏳ **Pending:** {$stats['pending_applications']}\n• ✅ **Approved (Active):** {$stats['approved_applications']}\n• ❌ **Rejected:** {$stats['rejected_applications']}\n\n**To check YOUR application status:**\n1. [Login](/login) to your account\n2. Go to your **Student Dashboard**\n3. Your application status is displayed at the top\n\n**Status meanings:**\n• **Pending** → Under review by admin\n• **Active** → Approved! You're in the program\n• **Rejected** → Not selected this cycle",
                'suggestions' => ['How to apply?', 'Login to account', 'Portal statistics', 'Contact support'],
            ];
        }

        // ── Eligibility / Criteria ─────────────────────────────────────
        if (preg_match('/\b(eligib|who can apply|qualif|require|criteria|minimum|cgpa|gpa)\b/', $message)) {
            $departments = $this->getDepartmentList();
            $deptNames = array_column($departments, 'name');
            $deptList = !empty($deptNames) ? implode(', ', $deptNames) : 'Various departments available';

            return [
                'text' => "📋 **Eligibility & Application Criteria:**\n\n**Who Can Apply:**\n• University students currently enrolled\n• Must have a valid university email or registration\n• All academic backgrounds are welcome\n\n**What You Need to Submit:**\n• ✅ Full Name (auto-filled from your account)\n• ✅ Email (auto-filled from your account)\n• ✅ **University / Institution** name\n• ✅ **Department** — choose from: {$deptList}\n• ✅ **Registration Number** — your unique ID (e.g., PEL-6583)\n• ✅ **CV / Resume** — PDF or DOCX format, max **2MB**\n\n**Selection Process:**\n1. Submit your application through the portal\n2. Admin reviews your profile & CV\n3. Status changes to **Active** (approved) or **Rejected**\n4. Approved interns are assigned a supervisor & department",
                'suggestions' => ['How to apply?', 'Show departments', 'What documents needed?', 'Create account'],
            ];
        }

        // ── Documents required ─────────────────────────────────────────
        if (preg_match('/\b(document|resume|cv|upload|attach|file|pdf|docx)\b/', $message)) {
            return [
                'text' => "📄 **Documents Required for Application:**\n\n**Mandatory:**\n• **CV / Resume** — PDF, DOC, or DOCX format\n• Maximum file size: **2MB**\n\n**Information You'll Provide:**\n• Your **University** name (e.g., UET Lahore, FAST, LUMS)\n• Your **Department** from the available options\n• Your **Registration Number** — must be unique\n\n**Note:** Your name and email are automatically taken from your registered account, so make sure they are correct during [registration](/register).\n\n💡 **Tip:** Ensure your CV highlights relevant skills, projects, and academic achievements for a better chance of approval!",
                'suggestions' => ['How to apply?', 'Am I eligible?', 'Create account', 'Show departments'],
            ];
        }

        // ── Tasks ──────────────────────────────────────────────────────
        if (preg_match('/\b(task|tasks|assignment|assignments|work|project)\b/', $message)) {
            $stats = $this->getPortalStats();
            $recentTasks = Task::with('intern')->latest()->take(5)->get();

            $taskText = "📋 **Task Management Overview:**\n\n• **Total Tasks:** {$stats['total_tasks']}\n• ⏳ Pending: **{$stats['pending_tasks']}**\n• 🔄 In Progress: **{$stats['in_progress_tasks']}**\n• ✅ Completed: **{$stats['completed_tasks']}**\n\n";

            if ($recentTasks->count() > 0) {
                $taskText .= "**Recent Tasks:**\n\n";
                foreach ($recentTasks as $i => $task) {
                    $num = $i + 1;
                    $internName = $task->intern->name ?? 'Unassigned';
                    $taskText .= "**{$num}. {$task->title}**\n→ Assigned to: {$internName} • Status: **{$task->status}**\n\n";
                }
            }

            $taskText .= "Tasks are assigned by supervisors and tracked through the portal. Each intern can view their tasks on their dashboard.";
            return [
                'text' => $taskText,
                'suggestions' => ['Portal statistics', 'Show interns', 'Show supervisors', 'Attendance info'],
            ];
        }

        // ── Attendance ─────────────────────────────────────────────────
        if (preg_match('/\b(attendance|present|absent|leave|check.?in|checkin)\b/', $message)) {
            $att = $this->getAttendanceStats();
            return [
                'text' => "✅ **Attendance Tracking System:**\n\n📊 **Current Stats:**\n• Total Records: **{$att['total']}**\n• ✅ Present: **{$att['present']}**\n• ❌ Absent: **{$att['absent']}**\n• 🏖️ Leave: **{$att['leave']}**\n• 📈 Overall Attendance Rate: **{$att['percentage']}%**\n\n**How Attendance Works:**\n• Attendance is marked daily by the admin\n• Status options: **Present**, **Absent**, or **Leave**\n• If marked Present, check-in time is recorded\n• Interns can view their attendance history on their dashboard\n\n**Tip:** Maintaining good attendance is important for your internship evaluation!",
                'suggestions' => ['Portal statistics', 'Show tasks', 'Show interns', 'How to apply?'],
            ];
        }

        // ── Announcements ──────────────────────────────────────────────
        if (preg_match('/\b(announcement|announcements|notice|news|update|updates|latest)\b/', $message)) {
            $announcements = $this->getLatestAnnouncements();
            if (empty($announcements)) {
                return [
                    'text' => "📢 No announcements have been posted yet. Check back later for updates from the admin!",
                    'suggestions' => ['Portal statistics', 'How to apply?', 'Show departments'],
                ];
            }
            $annText = "📢 **Latest Announcements:**\n\n";
            foreach ($announcements as $i => $a) {
                $num = $i + 1;
                $annText .= "**{$num}. {$a['title']}**\n→ {$a['body']}\n→ 📅 {$a['date']}\n\n";
            }
            $annText .= "Login to your dashboard to see full announcement details.";
            return [
                'text' => $annText,
                'suggestions' => ['Portal statistics', 'How to apply?', 'Show departments'],
            ];
        }

        // ── Stipend / Payment ──────────────────────────────────────────
        if (preg_match('/\b(paid|stipend|salary|money|compensation|pay|remuneration|allowance)\b/', $message)) {
            $stats = $this->getPortalStats();
            return [
                'text' => "💰 **Internship Compensation:**\n\nPEL offers competitive stipends to all selected interns. Currently **{$stats['active_interns']}** interns are actively enrolled in the program.\n\n**Perks include:**\n• Monthly stipend (varies by department & duration)\n• Hands-on industry experience\n• Certificate of completion\n• Potential full-time offer for top performers\n\nFor exact stipend details, please contact the admin or HR department after your application is approved.",
                'suggestions' => ['How to apply?', 'Show departments', 'Am I eligible?', 'Contact support'],
            ];
        }

        // ── Duration ───────────────────────────────────────────────────
        if (preg_match('/\b(duration|how long|weeks|months|time period|length)\b/', $message)) {
            return [
                'text' => "⏱️ **Internship Duration:**\n\n☀️ **Summer Internship:** 6 weeks\n→ Intensive, project-based experience\n\n🎓 **Capstone Internship:** 12 weeks\n→ FYP-integrated, deep-dive program\n\nDuring the internship:\n• You'll be assigned tasks by your **supervisor**\n• Your **attendance** is tracked daily\n• You'll receive regular **evaluations**\n\nOnce completed, your status changes from **Active** to **Completed** in the portal.",
                'suggestions' => ['How to apply?', 'Show supervisors', 'Show tasks', 'Portal statistics'],
            ];
        }

        // ── Location ───────────────────────────────────────────────────
        if (preg_match('/\b(location|where|address|lahore|office|plant|remote|hybrid)\b/', $message)) {
            return [
                'text' => "📍 **Internship Locations:**\n\n🏢 **PEL Head Office**\n14-KM Ferozepur Road, Lahore, Pakistan\n\n🏭 **Manufacturing Plants**\nLahore Industrial Area\n\n✉️ **Contact:** internships@pel.com.pk\n\nAll internship activities, attendance, and tasks are managed through this portal regardless of location.",
                'suggestions' => ['How to apply?', 'Show departments', 'Portal statistics'],
            ];
        }

        // ── Login / Account ────────────────────────────────────────────
        if (preg_match('/\b(login|sign in|account|password|forgot|reset|register|create account)\b/', $message)) {
            return [
                'text' => "🔐 **Account & Portal Access:**\n\n• **New User?** → [Register Here](/register)\n• **Existing User?** → [Sign In](/login)\n• **Forgot Password?** → Use the 'Forgot Password' link on login page\n\n**After Login:**\n• **Students** → Student Dashboard (apply, view tasks, attendance)\n• **Admins** → Admin Dashboard (manage interns, supervisors, departments)\n\n**Roles in the Portal:**\n• **Student** — Default role on registration\n• **Admin** — Manages the entire internship system",
                'suggestions' => ['How to apply?', 'Am I eligible?', 'Show departments'],
            ];
        }

        // ── About PEL ──────────────────────────────────────────────────
        if (preg_match('/\b(about pel|what is pel|pel company|pak elektron|history|legacy|who are you)\b/', $message)) {
            $stats = $this->getPortalStats();
            return [
                'text' => "🏭 **About Pak Elektron Limited (PEL):**\n\nFounded in **1956**, PEL is Pakistan's pioneer in electrical manufacturing and a flagship of the **Saigol Group**.\n\n**Our Portal Currently Manages:**\n• **{$stats['total_interns']}** interns across **{$stats['total_departments']}** departments\n• **{$stats['active_supervisors']}** active supervisors guiding interns\n• **{$stats['total_applications']}** total applications received\n\nPEL's two major divisions — **Appliances** and **Power** — offer diverse internship opportunities across Engineering, IT, and Business domains.",
                'suggestions' => ['Show departments', 'How to apply?', 'Portal statistics'],
            ];
        }

        // ── Contact ────────────────────────────────────────────────────
        if (preg_match('/\b(contact|email|phone|call|reach|support|help desk|help)\b/', $message)) {
            return [
                'text' => "📞 **Contact & Support:**\n\n✉️ **Email:** internships@pel.com.pk\n📍 **Address:** 14-KM Ferozepur Road, Lahore\n🌐 **Portal:** You're already here!\n\n**For portal issues:**\n• Login problems → Try password reset\n• Application issues → Contact admin via email\n• Technical bugs → Email with screenshots\n\n**For internship queries:**\n• Use this chatbot for instant answers!\n• Or login to your dashboard for personalized info",
                'suggestions' => ['How to apply?', 'Portal statistics', 'Show departments'],
            ];
        }

        // ── Thanks / Bye ──────────────────────────────────────────────
        if (preg_match('/\b(thank|thanks|bye|goodbye|see you|take care|appreciate)\b/', $message)) {
            return [
                'text' => "You're welcome! 😊 Glad I could help. If you have more questions about the PEL internship portal, just come back anytime.\n\n**Quick links:**\n→ [Apply Now](/register)\n→ [Sign In](/login)\n\n**Good luck with your application!** 🍀",
                'suggestions' => [],
            ];
        }

        // ── Default fallback ───────────────────────────────────────────
        $stats = $this->getPortalStats();
        return [
            'text' => "I appreciate your question! 🤔 I'm specialized in PEL portal-related topics.\n\n**Quick Portal Snapshot:**\n• {$stats['total_interns']} interns | {$stats['total_departments']} departments | {$stats['active_supervisors']} supervisors\n\nHere are some things I can help with:",
            'suggestions' => ['Show departments', 'Show supervisors', 'Show interns', 'How to apply?', 'Portal statistics', 'Announcements'],
        ];
    }

    /**
     * Helper to count array items (avoids using count() in Blade-like interpolation)
     */
    private function count(array $arr): int
    {
        return count($arr);
    }
}
