import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
const SystemStatusController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SystemStatusController.url(options),
    method: 'get',
})

SystemStatusController.definition = {
    methods: ["get","head"],
    url: '/api/system/status',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
SystemStatusController.url = (options?: RouteQueryOptions) => {
    return SystemStatusController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
SystemStatusController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SystemStatusController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
SystemStatusController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SystemStatusController.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
const SystemStatusControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: SystemStatusController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
SystemStatusControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: SystemStatusController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Api\SystemStatusController::__invoke
* @see app/Http/Controllers/Api/SystemStatusController.php:13
* @route '/api/system/status'
*/
SystemStatusControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: SystemStatusController.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

SystemStatusController.form = SystemStatusControllerForm

export default SystemStatusController