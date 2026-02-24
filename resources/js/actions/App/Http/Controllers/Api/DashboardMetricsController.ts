import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\DashboardMetricsController::__invoke
* @see app/Http/Controllers/Api/DashboardMetricsController.php:12
* @route '/api/dashboard/metrics'
*/
const DashboardMetricsController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DashboardMetricsController.url(options),
    method: 'get',
})

DashboardMetricsController.definition = {
    methods: ["get","head"],
    url: '/api/dashboard/metrics',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\DashboardMetricsController::__invoke
* @see app/Http/Controllers/Api/DashboardMetricsController.php:12
* @route '/api/dashboard/metrics'
*/
DashboardMetricsController.url = (options?: RouteQueryOptions) => {
    return DashboardMetricsController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\DashboardMetricsController::__invoke
* @see app/Http/Controllers/Api/DashboardMetricsController.php:12
* @route '/api/dashboard/metrics'
*/
DashboardMetricsController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DashboardMetricsController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\DashboardMetricsController::__invoke
* @see app/Http/Controllers/Api/DashboardMetricsController.php:12
* @route '/api/dashboard/metrics'
*/
DashboardMetricsController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: DashboardMetricsController.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\DashboardMetricsController::__invoke
* @see app/Http/Controllers/Api/DashboardMetricsController.php:12
* @route '/api/dashboard/metrics'
*/
const DashboardMetricsControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: DashboardMetricsController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\DashboardMetricsController::__invoke
* @see app/Http/Controllers/Api/DashboardMetricsController.php:12
* @route '/api/dashboard/metrics'
*/
DashboardMetricsControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: DashboardMetricsController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\DashboardMetricsController::__invoke
* @see app/Http/Controllers/Api/DashboardMetricsController.php:12
* @route '/api/dashboard/metrics'
*/
DashboardMetricsControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: DashboardMetricsController.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

DashboardMetricsController.form = DashboardMetricsControllerForm

export default DashboardMetricsController