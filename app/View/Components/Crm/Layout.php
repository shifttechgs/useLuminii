<?php

namespace App\View\Components\Crm;

use App\Models\BusinessClient;
use App\Models\ClientRequest;
use App\Models\Lead;
use App\Models\Invoice;
use App\Models\Job;
use App\Models\Notification;
use App\Models\Quote;
use App\Models\Subscription;
use Illuminate\View\Component;

class Layout extends Component
{
    public int $leadsCount;
    public int $newRequestsCount;
    public int $newLeadsCount;
    public int $overdueInvoicesCount;
    public int $draftQuotesCount;
    public int $activeJobsCount;
    public int $unreadNotifications;
    public ?Subscription $subscription;

    public function __construct(
        public string $title = 'Dashboard',
    ) {
        $this->subscription         = Subscription::current();
        $this->leadsCount           = BusinessClient::where('client_type', 'Lead')->count();
        $this->newRequestsCount     = ClientRequest::whereIn('status', ['New', 'InReview'])->count();
        $this->newLeadsCount        = Lead::whereIn('status', ['New', 'Contacted'])->count();
        $this->overdueInvoicesCount = Invoice::where('status', 'Overdue')->count();
        $this->draftQuotesCount     = Quote::where('status', 'Draft')->count();
        $this->activeJobsCount      = Job::whereIn('job_status', ['New', 'InProgress'])->count();
        $this->unreadNotifications  = auth()->check()
            ? Notification::where('user_id', auth()->id())->where('is_read', false)->count()
            : 0;
    }

    /** Sidebar tag for sections the current plan doesn't include. */
    public function needsUpgrade(string $feature): bool
    {
        return $this->subscription !== null && ! $this->subscription->hasFeature($feature);
    }

    public function render()
    {
        return view('components.crm.layout');
    }
}
