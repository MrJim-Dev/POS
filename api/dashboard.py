from database import fetchone, fetchall, execute

def get_stats():
    query = "SELECT * FROM dashboardview"
    result = fetchall(query)
    return result
