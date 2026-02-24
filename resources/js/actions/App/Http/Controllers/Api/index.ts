import DashboardMetricsController from './DashboardMetricsController'
import SystemStatusController from './SystemStatusController'
import OpportunityController from './OpportunityController'
import TaskController from './TaskController'
import TicketMessageController from './TicketMessageController'
import QuoteController from './QuoteController'
import CompanyController from './CompanyController'
import ContactController from './ContactController'
import TicketController from './TicketController'

const Api = {
    DashboardMetricsController: Object.assign(DashboardMetricsController, DashboardMetricsController),
    SystemStatusController: Object.assign(SystemStatusController, SystemStatusController),
    OpportunityController: Object.assign(OpportunityController, OpportunityController),
    TaskController: Object.assign(TaskController, TaskController),
    TicketMessageController: Object.assign(TicketMessageController, TicketMessageController),
    QuoteController: Object.assign(QuoteController, QuoteController),
    CompanyController: Object.assign(CompanyController, CompanyController),
    ContactController: Object.assign(ContactController, ContactController),
    TicketController: Object.assign(TicketController, TicketController),
}

export default Api