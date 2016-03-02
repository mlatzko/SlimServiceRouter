# SlimRouter
The SlimRouter provides access to one or more specified SlimService based 
implementations. It provides a caching for these requests so the data service
do not need to care about caching.

# Usage
Configure available service routes in the "_config.services.yml". Afterwards
the router should be able to route request to services.